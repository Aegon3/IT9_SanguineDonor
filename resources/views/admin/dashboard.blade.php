@extends('layouts.app')
@section('title', 'Admin Dashboard — SanguineDonor')

@section('sidebar')
<div class="nav-section">Main</div>
<a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active':'' }}"><i class="sidebar-icon">&#9632;</i> Dashboard</a>
<a href="{{ route('admin.donors.create') }}" class="{{ request()->routeIs('admin.donors.*') ? 'active':'' }}"><i class="sidebar-icon">&#43;</i> Register Donor</a>
<a href="{{ route('admin.appointments.index') }}" class="{{ request()->routeIs('admin.appointments.*') ? 'active':'' }}"><i class="sidebar-icon">&#9776;</i> Appointments</a>
<div class="nav-section">Records</div>
<a href="{{ route('admin.donations.index') }}" class="{{ request()->routeIs('admin.donations.*') ? 'active':'' }}"><i class="sidebar-icon">&#9679;</i> Record Donation</a>
<a href="{{ route('admin.inventory.index') }}" class="{{ request()->routeIs('admin.inventory.*') ? 'active':'' }}"><i class="sidebar-icon">&#9670;</i> Blood Inventory</a>
<a href="{{ route('admin.blood-requests.index') }}" class="{{ request()->routeIs('admin.blood-requests.*') ? 'active':'' }}"><i class="sidebar-icon">&#9651;</i> Blood Requests</a>
<a href="{{ route('admin.recipients.index') }}" class="{{ request()->routeIs('admin.recipients.*') ? 'active':'' }}"><i class="sidebar-icon">&#9745;</i> Recipients</a>
<a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.*') ? 'active':'' }}"><i class="sidebar-icon">&#9741;</i> Reports</a>
@endsection

@section('content')
<div class="page-title">Admin Dashboard</div>
<div class="page-sub">Overview of all blood donation operations</div>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-label">Total Donors</div>
        <div class="stat-value">{{ number_format($totalDonors) }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Units Available</div>
        <div class="stat-value">{{ number_format($unitsAvailable) }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Pending Requests</div>
        <div class="stat-value" style="color:var(--red-l)">{{ $pendingRequests }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Pending Recipients</div>
        <div class="stat-value" style="color:var(--amber)">{{ $pendingRecipients }}</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <span class="card-title">Recent Donors</span>
        <a href="{{ route('admin.donors.index') }}" class="view-all">View all &rarr;</a>
    </div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Name</th><th>Blood Type</th><th>Last Donation</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($recentDonors as $d)
            <tr>
                <td><div class="donor-cell"><div class="avatar">{{ $d->initials }}</div>{{ $d->full_name }}</div></td>
                <td>{{ $d->blood_type }}</td>
                <td>{{ $d->last_donation_date ? \Carbon\Carbon::parse($d->last_donation_date)->format('M j, Y') : '—' }}</td>
                <td><span class="status status-{{ strtolower($d->status) }}">{{ $d->status }}</span></td>
                <td>
                    <a href="{{ route('admin.donors.edit', $d->id) }}" class="btn btn-outline btn-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.donors.destroy', $d->id) }}" style="display:inline" onsubmit="return confirm('Remove?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-ghost btn-sm">Remove</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="color:var(--muted);text-align:center;padding:24px">No donors yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
