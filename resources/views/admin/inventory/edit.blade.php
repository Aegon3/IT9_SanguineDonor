@extends('layouts.app')
@section('title', 'Update Inventory — SanguineDonor')

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
<div class="page-title">Update Inventory</div>
<div class="page-sub">Adjust stock for {{ $inventory->blood_type }}</div>

<form method="POST" action="{{ route('admin.inventory.update', $inventory->id) }}">
    @csrf @method('PUT')

    <div class="form-section">
        <div class="form-section-title">Stock Details — {{ $inventory->blood_type }}</div>
        <div class="form-grid">
            <div class="form-group">
                <label>Units Available</label>
                <input type="number" name="units_available" min="0" value="{{ old('units_available', $inventory->units_available) }}" required>
            </div>
            <div class="form-group">
                <label>Capacity</label>
                <input type="number" name="capacity" min="1" value="{{ old('capacity', $inventory->capacity) }}" required>
            </div>
            <div class="form-group">
                <label>Expiry Date</label>
                <input type="date" name="expiry_date" value="{{ old('expiry_date', $inventory->expiry_date) }}">
            </div>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-red">Save Changes</button>
        <a href="{{ route('admin.inventory.index') }}" class="btn btn-outline">Cancel</a>
    </div>
</form>
@endsection
