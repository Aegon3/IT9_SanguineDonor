@extends('layouts.app')
@section('title', 'Reports — SanguineDonor')
@section('sidebar')
@include('admin.partials.sidebar')
@endsection
@section('content')
<div class="page-title">Reports</div>
<div class="page-sub">Summary of donations, inventory, and requests</div>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-label">Total Donations</div>
        <div class="stat-value">{{ $totalDonations }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Total Volume</div>
        <div class="stat-value" style="font-size:1.2rem;margin-top:6px">{{ number_format($totalVolume) }} mL</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Blood Requests</div>
        <div class="stat-value">{{ $totalRequests }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Approved Requests</div>
        <div class="stat-value">{{ $approvedRequests }}</div>
    </div>
</div>

<div class="card">
    <div class="card-title" style="margin-bottom:16px">Donations by Blood Type</div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Blood Type</th><th>Total Donations</th></tr></thead>
            <tbody>
            @forelse($donationsByType as $d)
            <tr>
                <td><strong>{{ $d->blood_type }}</strong></td>
                <td>{{ $d->total }}</td>
            </tr>
            @empty
            <tr><td colspan="2" style="color:var(--muted);text-align:center;padding:20px">No donation data yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-title" style="margin-bottom:16px">Current Blood Inventory</div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Blood Type</th><th>Units Available</th><th>Capacity</th><th>Status</th></tr></thead>
            <tbody>
            @foreach($inventory as $item)
            <tr>
                <td><strong>{{ $item->blood_type }}</strong></td>
                <td>{{ $item->units_available }}</td>
                <td>{{ $item->capacity }}</td>
                <td><span class="status" style="background:{{ $item->status_color }}22;color:{{ $item->status_color }}">{{ $item->status_label }}</span></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="card">
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
            <tr><td colspan="3" style="color:var(--muted);text-align:center;padding:20px">No donation data yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

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
            <tr><td colspan="4" style="color:var(--muted);text-align:center;padding:20px">No donations yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
