@extends('layouts.app')
@section('title', 'My Dashboard — SanguineDonor')
@section('sidebar')
<div class="nav-section">Donor</div>
<a href="{{ route('donor.dashboard') }}" class="{{ request()->routeIs('donor.dashboard') ? 'active':'' }}"><i class="sidebar-icon">&#9632;</i> My Dashboard</a>
<a href="{{ route('donor.schedule') }}" class="{{ request()->routeIs('donor.schedule') ? 'active':'' }}"><i class="sidebar-icon">&#9776;</i> Schedule Donation</a>
<a href="{{ route('donor.history') }}" class="{{ request()->routeIs('donor.history') ? 'active':'' }}"><i class="sidebar-icon">&#9679;</i> Donation History</a>
<a href="{{ route('donor.profile') }}" class="{{ request()->routeIs('donor.profile') ? 'active':'' }}"><i class="sidebar-icon">&#43;</i> My Profile</a>
@endsection
@section('content')
<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:24px">
    <div>
        <div class="page-title">Welcome back, {{ auth()->user()->name }}</div>
        <div class="page-sub">Your donor dashboard overview.</div>
    </div>
    @if($donor)
    <div style="background:var(--surface2);border:1px solid var(--border);border-radius:6px;padding:16px 24px;text-align:center">
        <div style="font-size:2rem;font-weight:700;color:var(--red-l)">{{ $donor->blood_type }}</div>
    </div>
    @endif
</div>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-label">Total Donations</div>
        <div class="stat-value">{{ $donor->total_donations ?? 0 }}</div>
        <div style="font-size:.72rem;color:var(--muted)">Since registration</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Lives Impacted</div>
        <div class="stat-value">{{ ($donor->total_donations ?? 0) * 3 }}</div>
        <div style="font-size:.72rem;color:var(--muted)">Estimated recipients</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Next Eligible</div>
        <div class="stat-value" style="font-size:1rem;margin-top:8px">
            {{ $donor && $donor->last_donation_date ? \Carbon\Carbon::parse($donor->last_donation_date)->addDays(90)->format('M j, Y') : 'Now' }}
        </div>
    </div>
</div>

@if($appointment)
<div class="card">
    <div class="card-header">
        <span class="card-title">Upcoming Appointment</span>
        <a href="{{ route('donor.schedule') }}" class="view-all">Manage &rarr;</a>
    </div>
    <div style="background:var(--bg);border:1px solid var(--border);border-radius:4px;padding:14px 16px">
        <div style="font-size:.78rem;font-weight:600;color:var(--text)">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F j, Y') }}</div>
        <div style="font-size:1.1rem;font-weight:700;margin:4px 0">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</div>
        <div style="font-size:.75rem;color:var(--muted)">{{ $appointment->location }}</div>
        <div style="margin-top:8px"><span class="status status-{{ strtolower($appointment->status) }}">{{ $appointment->status }}</span></div>
    </div>
</div>
@endif

<div class="card">
    <div class="card-header">
        <span class="card-title">Recent Donations</span>
        <a href="{{ route('donor.history') }}" class="view-all">View all &rarr;</a>
    </div>
    @if($donations->count())
    <div class="table-wrap">
        <table>
            <thead><tr><th>Date</th><th>Blood Type</th><th>Volume</th></tr></thead>
            <tbody>
            @foreach($donations as $d)
            <tr>
                <td>{{ \Carbon\Carbon::parse($d->donation_date)->format('M j, Y') }}</td>
                <td>{{ $d->blood_type }}</td>
                <td>{{ $d->volume_ml }} mL</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div style="color:var(--muted);font-size:.82rem;text-align:center;padding:20px">No donations recorded yet.</div>
    @endif
</div>

@if(!$donor)
<div class="card">
    <div style="text-align:center;padding:32px 20px">
        <div style="font-size:1rem;font-weight:600;color:var(--text);margin-bottom:8px">Profile Not Set Up Yet</div>
        <div style="font-size:.82rem;color:var(--muted)">Please wait for an admin to complete your registration.</div>
    </div>
</div>
@endif
@endsection
