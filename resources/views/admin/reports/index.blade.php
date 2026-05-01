@extends('layouts.app')
@section('title', 'Reports — SanguineDonor')
@section('sidebar')
@include('admin.partials.sidebar')
@endsection
@section('content')

<style>
@media print {
    .topbar, .sidebar, .no-print { display:none !important; }
    .main-content { margin:0 !important; padding:0 !important; }
    body { background:#fff !important; color:#000 !important; }
    .card { border:1px solid #ccc !important; background:#fff !important; page-break-inside:avoid; }
    .stat-card { border:1px solid #ccc !important; background:#fff !important; }
    .stat-label, .stat-value, .card-title, td, th { color:#000 !important; }
    table { border-collapse:collapse; width:100%; }
    th, td { border:1px solid #ddd; padding:6px 10px; font-size:11px; }
    .print-header { display:block !important; }
}
.print-header { display:none; }
</style>

<div class="print-header" style="margin-bottom:20px;padding-bottom:12px;border-bottom:2px solid #c0392b">
    <div style="font-size:1.2rem;font-weight:700">SanguineDonor — Report</div>
    <div style="font-size:.8rem;color:#666">Generated: {{ \Carbon\Carbon::now()->format('F j, Y g:i A') }} &nbsp;|&nbsp; Period: {{ ucfirst($period) }}</div>
</div>

<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px">
    <div>
        <div class="page-title">Reports</div>
        <div class="page-sub">Summary of donations, donors, inventory, and requests</div>
    </div>
    {{-- Filters + Export --}}
    <div style="display:flex;flex-direction:column;gap:10px;align-items:flex-end">
        {{-- Period quick filters --}}
        <div style="display:flex;gap:6px;align-items:center;flex-wrap:wrap">
            @foreach(['all' => 'All Time', 'today' => 'Today', 'week' => 'This Week', 'month' => 'This Month', 'year' => 'This Year'] as $val => $label)
            <a href="{{ route('admin.reports.index', ['period' => $val]) }}"
               style="padding:6px 14px;border-radius:20px;font-size:.75rem;font-weight:500;text-decoration:none;transition:all .15s;
                      {{ $period === $val && !request('from')
                         ? 'background:var(--red);color:#fff;border:1px solid var(--red)'
                         : 'background:var(--surface2);color:var(--muted);border:1px solid var(--border2)' }}">
                {{ $label }}
            </a>
            @endforeach
        </div>
        {{-- Custom date range --}}
        <form method="GET" action="{{ route('admin.reports.index') }}" style="display:flex;align-items:center;gap:8px;flex-wrap:wrap">
            <input type="hidden" name="period" value="custom">
            <div style="display:flex;align-items:center;gap:6px">
                <label style="font-size:.7rem;color:var(--muted);text-transform:uppercase;letter-spacing:.05em">From</label>
                <input type="date" name="from" value="{{ request('from') }}"
                    style="padding:5px 10px;background:var(--surface2);border:1px solid var(--border2);border-radius:6px;color:var(--text);font-size:.78rem;font-family:'Inter',sans-serif;outline:none">
            </div>
            <div style="display:flex;align-items:center;gap:6px">
                <label style="font-size:.7rem;color:var(--muted);text-transform:uppercase;letter-spacing:.05em">To</label>
                <input type="date" name="to" value="{{ request('to') }}"
                    style="padding:5px 10px;background:var(--surface2);border:1px solid var(--border2);border-radius:6px;color:var(--text);font-size:.78rem;font-family:'Inter',sans-serif;outline:none">
            </div>
            <button type="submit"
                style="padding:5px 14px;background:var(--red);color:#fff;border:none;border-radius:6px;font-size:.78rem;font-weight:600;font-family:'Inter',sans-serif;cursor:pointer">
                Apply
            </button>
            @if(request('from') || request('to'))
            <a href="{{ route('admin.reports.index') }}"
                style="padding:5px 10px;background:var(--surface2);color:var(--muted);border:1px solid var(--border2);border-radius:6px;font-size:.75rem;text-decoration:none">
                Clear
            </a>
            @endif
        </form>
        @if(request('from') || request('to'))
        <div style="font-size:.72rem;color:var(--red-l)">
            Showing: {{ request('from') ?? '...' }} → {{ request('to') ?? 'now' }}
        </div>
        @endif
        {{-- Export button --}}
        <button onclick="window.print()" class="no-print"
            style="padding:7px 16px;background:var(--surface2);border:1px solid var(--border2);border-radius:8px;color:var(--text);font-size:.78rem;font-weight:500;font-family:'Inter',sans-serif;cursor:pointer;display:flex;align-items:center;gap:6px;transition:border-color .15s"
            onmouseover="this.style.borderColor='var(--red-l)'" onmouseout="this.style.borderColor='var(--border2)'">
            &#8681; Export / Print PDF
        </button>
    </div>
</div>

{{-- Summary stats --}}
<div class="stat-grid" style="margin-bottom:24px">
    <div class="stat-card">
        <div class="stat-label">Total Donations</div>
        <div class="stat-value">{{ $totalDonations }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Total Volume</div>
        <div class="stat-value" style="font-size:1.2rem;margin-top:6px">{{ number_format($totalVolume) }} mL</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Donors Registered</div>
        <div class="stat-value">{{ $donorsRegistered }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Blood Requests</div>
        <div class="stat-value">{{ $totalRequests }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Approved Requests</div>
        <div class="stat-value">{{ $approvedRequests }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Appointments</div>
        <div class="stat-value">{{ $totalAppointments }}</div>
    </div>
</div>

{{-- Donations by blood type --}}
<div class="card" style="margin-bottom:20px">
    <div class="card-title" style="margin-bottom:16px">Blood Donated by Type</div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Blood Type</th><th>Total Donations</th><th>Share</th></tr></thead>
            <tbody>
            @forelse($donationsByType as $d)
            <tr>
                <td><strong>{{ $d->blood_type }}</strong></td>
                <td>{{ $d->total }}</td>
                <td>
                    <div style="display:flex;align-items:center;gap:8px">
                        <div style="flex:1;background:var(--border);border-radius:99px;height:6px;overflow:hidden">
                            <div style="height:100%;width:{{ $totalDonations > 0 ? round(($d->total/$totalDonations)*100) : 0 }}%;background:var(--red-l);border-radius:99px"></div>
                        </div>
                        <span style="font-size:.72rem;color:var(--muted);min-width:30px">{{ $totalDonations > 0 ? round(($d->total/$totalDonations)*100) : 0 }}%</span>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="3" style="color:var(--muted);text-align:center;padding:20px">No donation data for this period.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Donors registered --}}
<div class="card" style="margin-bottom:20px">
    <div class="card-title" style="margin-bottom:16px">Top Donors</div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Donor</th><th>Blood Type</th><th>Total Donations</th></tr></thead>
            <tbody>
            @forelse($topDonors as $d)
            <tr>
                <td><div class="donor-cell"><div class="avatar">{{ $d->initials }}</div>{{ $d->full_name }}</div></td>
                <td>{{ $d->blood_type }}</td>
                <td>{{ $d->total_donations }}</td>
            </tr>
            @empty
            <tr><td colspan="3" style="color:var(--muted);text-align:center;padding:20px">No donor data yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Blood Inventory --}}
<div class="card" style="margin-bottom:20px">
    <div class="card-title" style="margin-bottom:16px">Current Blood Inventory</div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Blood Type</th><th>Units Available</th><th>Capacity</th><th>Fill %</th><th>Status</th></tr></thead>
            <tbody>
            @foreach($inventory as $item)
            <tr>
                <td><strong>{{ $item->blood_type }}</strong></td>
                <td>{{ number_format($item->units_available) }}</td>
                <td>{{ number_format($item->capacity) }}</td>
                <td>
                    <div style="display:flex;align-items:center;gap:8px">
                        <div style="flex:1;background:var(--border);border-radius:99px;height:6px;overflow:hidden">
                            <div style="height:100%;width:{{ $item->percentage }}%;background:{{ $item->status_color }};border-radius:99px"></div>
                        </div>
                        <span style="font-size:.72rem;color:var(--muted);min-width:30px">{{ $item->percentage }}%</span>
                    </div>
                </td>
                <td><span class="status" style="background:{{ $item->status_color }}22;color:{{ $item->status_color }}">{{ $item->status_label }}</span></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Recent Donations --}}
<div class="card">
    <div class="card-title" style="margin-bottom:16px">Recent Donations</div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Donor</th><th>Blood Type</th><th>Volume</th><th>Date</th></tr></thead>
            <tbody>
            @forelse($recentDonations as $d)
            <tr>
                <td>{{ $d->donor->full_name }}</td>
                <td>{{ $d->blood_type }}</td>
                <td>{{ $d->volume_ml }} mL</td>
                <td>{{ \Carbon\Carbon::parse($d->donation_date)->format('M j, Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="4" style="color:var(--muted);text-align:center;padding:20px">No donations for this period.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection