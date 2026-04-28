@extends('layouts.app')
@section('title', 'Register Donor — SanguineDonor')

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
<div class="page-title">Register New Donor</div>
<div class="page-sub">Add a new blood donor profile to the system</div>

<form method="POST" action="{{ route('admin.donors.store') }}">
    @csrf

    <div class="form-section">
        <div class="form-section-title">Personal Information</div>
        <div class="form-grid">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="first_name" placeholder="e.g. Maria" value="{{ old('first_name') }}" required>
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" placeholder="e.g. Santos" value="{{ old('last_name') }}" required>
            </div>
            <div class="form-group">
                <label>Date of Birth</label>
                <input type="date" name="date_of_birth" placeholder="MM / DD / YYYY" value="{{ old('date_of_birth') }}" required>
            </div>
            <div class="form-group">
                <label>Gender</label>
                <select name="gender" required>
                    <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Select gender</option>
                    @foreach(['Male','Female','Other'] as $g)
                    <option value="{{ $g }}" {{ old('gender') === $g ? 'selected':'' }}>{{ $g }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Contact Number</label>
                <input type="text" name="contact_number" placeholder="+63 0XX XXX XXXX" value="{{ old('contact_number') }}" required>
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="donor@email.com" value="{{ old('email') }}">
            </div>
            <div class="form-group" style="grid-column:1/-1">
                <label>Address</label>
                <input type="text" name="address" placeholder="Street, City, Province" value="{{ old('address') }}" required>
            </div>
        </div>
    </div>

    <div class="form-section">
        <div class="form-section-title">Medical Information</div>
        <div class="form-grid">
            <div class="form-group">
                <label>Blood Type</label>
                <select name="blood_type" required>
                    <option value="" disabled {{ old('blood_type') ? '' : 'selected' }}>Select blood type</option>
                    @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bt)
                    <option value="{{ $bt }}" {{ old('blood_type') === $bt ? 'selected':'' }}>{{ $bt }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" required>
                    @foreach(['Active','Pending','Inactive'] as $s)
                    <option value="{{ $s }}" {{ old('status','Active') === $s ? 'selected':'' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-red">Register Donor</button>
        <a href="{{ route('admin.donors.index') }}" class="btn btn-outline">Cancel</a>
    </div>
</form>
@endsection
