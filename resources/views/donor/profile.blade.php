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
<div class="page-sub">Manage your personal information and account security</div>

@if(session('success'))
<div style="background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);color:#22c55e;padding:10px 14px;border-radius:6px;font-size:.8rem;margin-bottom:20px">{{ session('success') }}</div>
@endif
@if($errors->any())
<div style="background:rgba(231,76,60,.1);border:1px solid rgba(231,76,60,.3);color:#e74c3c;padding:10px 14px;border-radius:6px;font-size:.8rem;margin-bottom:20px">{{ $errors->first() }}</div>
@endif

@if($donor)

{{-- Tab switcher --}}
<div style="display:flex;gap:0;border-bottom:1px solid var(--border);margin-bottom:24px">
    <button onclick="showTab('profile')" id="tab-profile"
        style="padding:9px 20px;font-size:.82rem;font-weight:500;cursor:pointer;border:none;border-bottom:2px solid var(--red-l);margin-bottom:-1px;background:none;font-family:'Inter',sans-serif;color:#fff">
        Personal Info
    </button>
    <button onclick="showTab('password')" id="tab-password"
        style="padding:9px 20px;font-size:.82rem;font-weight:500;cursor:pointer;border:none;border-bottom:2px solid transparent;margin-bottom:-1px;background:none;font-family:'Inter',sans-serif;color:var(--muted)">
        Change Password
    </button>
</div>

{{-- Personal Info Tab --}}
<div id="pane-profile">
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
</div>

{{-- Password Tab --}}
<div id="pane-password" style="display:none">
<form method="POST" action="{{ route('donor.password.update') }}">
    @csrf
    <div class="form-section">
        <div class="form-section-title">Change Password</div>
        <div class="form-grid">
            <div class="form-group" style="grid-column:1/-1">
                <label>Current Password</label>
                <input type="password" name="current_password" placeholder="Enter current password" required>
            </div>
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="password" placeholder="Min. 6 characters" required>
            </div>
            <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" name="password_confirmation" placeholder="Repeat new password" required>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-red">Update Password</button>
    </div>
</form>
</div>

<script>
function showTab(tab) {
    document.getElementById('pane-profile').style.display  = tab === 'profile'  ? '' : 'none';
    document.getElementById('pane-password').style.display = tab === 'password' ? '' : 'none';
    document.getElementById('tab-profile').style.borderBottomColor  = tab === 'profile'  ? 'var(--red-l)' : 'transparent';
    document.getElementById('tab-password').style.borderBottomColor = tab === 'password' ? 'var(--red-l)' : 'transparent';
    document.getElementById('tab-profile').style.color  = tab === 'profile'  ? '#fff' : 'var(--muted)';
    document.getElementById('tab-password').style.color = tab === 'password' ? '#fff' : 'var(--muted)';
}
// If there's a password error, auto-switch to password tab
@if($errors->has('current_password') || $errors->has('password'))
showTab('password');
@endif
</script>

@else
<div class="card">
    <div style="color:var(--muted);text-align:center;padding:32px">No donor profile found. Please contact an admin.</div>
</div>
@endif
@endsection