@extends('layouts.app')
@section('title', 'Create Appointment — SanguineDonor')
@section('sidebar')
@include('admin.partials.sidebar')
@endsection
@section('content')
<div class="page-title">Create Appointment</div>
<div class="page-sub">Schedule an appointment on behalf of a donor</div>

@if($errors->any())
<div style="background:rgba(231,76,60,.1);border:1px solid rgba(231,76,60,.3);color:#e74c3c;padding:10px 14px;border-radius:4px;font-size:.8rem;margin-bottom:16px">
    {{ $errors->first() }}
</div>
@endif

<div class="form-section">
    <div class="form-section-title">Appointment Details</div>
    <form method="POST" action="{{ route('admin.appointments.store') }}">
        @csrf
        <div class="form-grid">
            <div class="form-group" style="grid-column:1/-1">
                <label>Donor</label>
                <select name="donor_id" required>
                    <option value="">— Select Donor —</option>
                    @foreach($donors as $d)
                    <option value="{{ $d->id }}" {{ old('donor_id') == $d->id ? 'selected':'' }}>
                        {{ $d->full_name }} ({{ $d->blood_type }})
                    </option>
                    @endforeach
                </select>
            </div>
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
            <div class="form-group">
                <label>Status</label>
                <select name="status" required>
                    @foreach(['Pending','Confirmed','Completed','Cancelled'] as $s)
                    <option value="{{ $s }}" {{ old('status','Confirmed') === $s ? 'selected':'' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-red">Create Appointment</button>
            <a href="{{ route('admin.appointments.index') }}" class="btn btn-ghost">Cancel</a>
        </div>
    </form>
</div>
@endsection