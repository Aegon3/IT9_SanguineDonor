@extends('layouts.app')
@section('title', 'My Profile — SanguineDonor')
@section('sidebar')
<div class="nav-section">Donor</div>
<a href="{{ route('donor.dashboard') }}"><i class="sidebar-icon">&#9632;</i> My Dashboard</a>
<a href="{{ route('donor.schedule') }}"><i class="sidebar-icon">&#9776;</i> Schedule Donation</a>
<a href="{{ route('donor.history') }}"><i class="sidebar-icon">&#9679;</i> Donation History</a>
<a href="{{ route('donor.profile') }}" class="active"><i class="sidebar-icon">&#43;</i> My Profile</a>
@endsection
@section('content')
<div class="page-title">My Profile</div>
<div class="page-sub">Update your personal information</div>

@if($donor)
<form method="POST" action="{{ route('donor.profile.update') }}">
    @csrf
    <div class="form-section">
        <div class="form-section-title">Personal Information</div>
        <div class="form-grid">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="first_name" value="{{ old('first_name', $donor->first_name) }}" required>
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" value="{{ old('last_name', $donor->last_name) }}" required>
            </div>
            <div class="form-group">
                <label>Date of Birth</label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $donor->date_of_birth) }}" required>
            </div>
            <div class="form-group">
                <label>Gender</label>
                <select name="gender" required>
                    @foreach(['Male','Female','Other'] as $g)
                    <option value="{{ $g }}" {{ old('gender', $donor->gender) === $g ? 'selected':'' }}>{{ $g }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Contact Number</label>
                <input type="text" name="contact_number" value="{{ old('contact_number', $donor->contact_number) }}" required>
            </div>
            <div class="form-group" style="grid-column:1/-1">
                <label>Address</label>
                <input type="text" name="address" value="{{ old('address', $donor->address) }}" required>
            </div>
        </div>
    </div>
    <div class="form-section">
        <div class="form-section-title">Medical Information</div>
        <div class="form-grid">
            <div class="form-group">
                <label>Blood Type</label>
                <input type="text" value="{{ $donor->blood_type }}" disabled style="opacity:.5">
                <span style="font-size:.68rem;color:var(--muted)">Contact admin to change blood type.</span>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-red">Save Changes</button>
    </div>
</form>
@else
<div class="card">
    <div style="color:var(--muted);text-align:center;padding:32px">No donor profile found. Please contact an admin.</div>
</div>
@endif
@endsection
