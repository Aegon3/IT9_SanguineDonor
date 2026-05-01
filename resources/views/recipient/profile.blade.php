@extends('layouts.app')
@section('title', 'My Profile — SanguineDonor')
@section('sidebar')
<div class="nav-section">Recipient</div>
<a href="{{ route('recipient.dashboard') }}"><i class="sidebar-icon">&#9632;</i> My Dashboard</a>
@if(auth()->user()->isApproved())
<a href="{{ route('recipient.request') }}"><i class="sidebar-icon">&#9679;</i> Request Blood</a>
<a href="{{ route('recipient.my-requests') }}"><i class="sidebar-icon">&#9776;</i> My Requests</a>
@endif
<a href="{{ route('recipient.profile') }}" class="active"><i class="sidebar-icon">&#43;</i> My Profile</a>
@endsection
@section('content')

<div class="page-title">My Profile</div>
<div class="page-sub">Manage your account security</div>

@if(session('success'))
<div style="background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);color:#22c55e;padding:10px 14px;border-radius:6px;font-size:.8rem;margin-bottom:20px">{{ session('success') }}</div>
@endif
@if($errors->any())
<div style="background:rgba(231,76,60,.1);border:1px solid rgba(231,76,60,.3);color:#e74c3c;padding:10px 14px;border-radius:6px;font-size:.8rem;margin-bottom:20px">{{ $errors->first() }}</div>
@endif

{{-- Account info card --}}
<div style="background:var(--surface);border:1px solid var(--border);border-radius:12px;padding:24px;margin-bottom:20px;display:flex;align-items:center;gap:20px">
    <div style="width:56px;height:56px;background:var(--red);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.2rem;font-weight:700;color:#fff;flex-shrink:0">
        {{ strtoupper(substr(auth()->user()->name,0,2)) }}
    </div>
    <div>
        <div style="font-size:1rem;font-weight:600">{{ auth()->user()->name }}</div>
        <div style="font-size:.78rem;color:var(--muted)">{{ auth()->user()->email }}</div>
        <div style="margin-top:6px">
            <span class="status {{ auth()->user()->isApproved() ? 'status-active' : 'status-pending' }}">
                {{ auth()->user()->isApproved() ? 'Verified' : 'Pending Approval' }}
            </span>
        </div>
    </div>
</div>

{{-- Change Password --}}
<form method="POST" action="{{ route('recipient.password.update') }}">
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
@endsection