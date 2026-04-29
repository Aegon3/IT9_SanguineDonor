@extends('layouts.app')
@section('title', 'Schedule Donation — SanguineDonor')
@section('sidebar')
<div class="nav-section">Donor</div>
<a href="{{ route('donor.dashboard') }}"><i class="sidebar-icon">&#9632;</i> My Dashboard</a>
<a href="{{ route('donor.schedule') }}" class="active"><i class="sidebar-icon">&#9776;</i> Schedule Donation</a>
<a href="{{ route('donor.history') }}"><i class="sidebar-icon">&#9679;</i> Donation History</a>
<a href="{{ route('donor.profile') }}"><i class="sidebar-icon">&#43;</i> My Profile</a>
@endsection
@section('content')
<div class="page-title">Schedule Donation</div>
<div class="page-sub">Set an appointment for a blood donation session</div>

<div class="form-section">
    <div class="form-section-title">Book Appointment</div>
    @if($donor)
    <form method="POST" action="{{ route('donor.schedule.store') }}">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label>Appointment Date</label>
                <input type="date" name="appointment_date" min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ old('appointment_date') }}" required>
            </div>
            <div class="form-group">
                <label>Appointment Time</label>
                <input type="time" name="appointment_time" value="{{ old('appointment_time', '09:00') }}" required>
            </div>
            <div class="form-group" style="grid-column:1/-1">
                <label>Location</label>
                <input type="text" name="location" value="{{ old('location', 'Davao Blood Donation Center, Davao City') }}" required>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-red">Confirm Appointment</button>
        </div>
    </form>
    @else
    <div style="color:var(--muted);font-size:.82rem;padding:16px 0">
        Your donor profile is still being set up. Please wait for admin approval before scheduling an appointment.
    </div>
    @endif
</div>

<div class="card">
    <div class="card-title" style="margin-bottom:16px">My Appointments</div>
    @if($appointments->count())
    <div class="table-wrap">
        <table>
            <thead><tr><th>Date</th><th>Time</th><th>Location</th><th>Status</th><th>Action</th></tr></thead>
            <tbody>
            @foreach($appointments as $a)
            <tr>
                <td>{{ \Carbon\Carbon::parse($a->appointment_date)->format('M j, Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($a->appointment_time)->format('g:i A') }}</td>
                <td style="font-size:.78rem">{{ $a->location }}</td>
                <td><span class="status status-{{ strtolower($a->status) }}">{{ $a->status }}</span></td>
                <td>
                    @if(in_array($a->status, ['Pending','Confirmed']))
                    <form method="POST" action="{{ route('donor.schedule.cancel', $a->id) }}" onsubmit="return confirm('Cancel this appointment?')">
                        @csrf
                        <button type="submit" class="btn btn-ghost btn-sm">Cancel</button>
                    </form>
                    @else
                    <span style="color:var(--muted);font-size:.75rem">—</span>
                    @endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div style="color:var(--muted);font-size:.82rem;text-align:center;padding:20px">No appointments yet.</div>
    @endif
</div>
@endsection