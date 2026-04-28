@extends('layouts.app')
@section('title', 'Record Donation — SanguineDonor')
@section('sidebar')
@include('admin.partials.sidebar')
@endsection
@section('content')
<div class="page-title">Record Blood Donation</div>
<div class="page-sub">Document a completed blood donation and update inventory</div>
<form method="POST" action="{{ route('admin.donations.store') }}">
    @csrf
    <div class="form-section">
        <div class="form-section-title">Donor Lookup</div>
        <div class="form-grid">
            <div class="form-group">
                <label>Select Donor</label>
                <select name="donor_id" required>
                    <option value="">Search donor...</option>
                    @foreach($donors as $d)
                    <option value="{{ $d->id }}" {{ old('donor_id') == $d->id ? 'selected':'' }}>
                        {{ $d->full_name }} — {{ $d->blood_type }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Linked Appointment <span style="color:var(--muted2)">(optional)</span></label>
                <select name="appointment_id">
                    <option value="">Select from confirmed appointments...</option>
                    @foreach($appointments as $a)
                    <option value="{{ $a->id }}" {{ old('appointment_id') == $a->id ? 'selected':'' }}>
                        {{ $a->donor->full_name }} — {{ \Carbon\Carbon::parse($a->appointment_date)->format('M j, Y') }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form-section">
        <div class="form-section-title">Donation Details</div>
        <div class="form-grid">
            <div class="form-group">
                <label>Blood Type Confirmed</label>
                <select name="blood_type" required>
                    <option value="">Select...</option>
                    @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bt)
                    <option value="{{ $bt }}" {{ old('blood_type') === $bt ? 'selected':'' }}>{{ $bt }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Volume Collected (mL)</label>
                <input type="number" name="volume_ml" min="100" max="600" value="{{ old('volume_ml', 450) }}" required>
            </div>
            <div class="form-group">
                <label>Donation Date</label>
                <input type="date" name="donation_date" value="{{ old('donation_date', date('Y-m-d')) }}" required>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-red">Save Donation</button>
        <a href="{{ route('admin.donations.index') }}" class="btn btn-outline">Cancel</a>
    </div>
</form>
@endsection
