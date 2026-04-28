@extends('layouts.app')
@section('title', 'Request Blood — SanguineDonor')
@section('sidebar')
<div class="nav-section">Recipient</div>
<a href="{{ route('recipient.dashboard') }}"><i class="sidebar-icon">&#9632;</i> My Dashboard</a>
<a href="{{ route('recipient.request') }}" class="active"><i class="sidebar-icon">&#9679;</i> Request Blood</a>
<a href="{{ route('recipient.my-requests') }}"><i class="sidebar-icon">&#9776;</i> My Requests</a>
@endsection
@section('content')
<div class="page-title">Request Blood</div>
<div class="page-sub">Submit a blood request — inventory will be checked automatically</div>

@if($errors->has('rate_limit'))
<div class="alert alert-error">{{ $errors->first('rate_limit') }}</div>
@endif

<div class="form-section">
    <div class="form-section-title">Available Blood Types</div>
    <div style="display:flex;flex-direction:column;gap:8px;margin-bottom:24px">
        @foreach($inventory as $item)
        @php $low = $item->units_available < 100; @endphp
        <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 16px;background:{{ $low ? 'rgba(192,57,43,.08)':'var(--bg)' }};border:1px solid {{ $low ? 'rgba(192,57,43,.3)':'var(--border)' }};border-radius:4px">
            <span style="font-size:1rem;font-weight:700;color:var(--text)">{{ $item->blood_type }}</span>
            <span style="font-size:.8rem;color:var(--muted)">{{ number_format($item->units_available) }} units available</span>
        </div>
        @endforeach
    </div>

    <div class="form-section-title">Submit Request</div>
    <form method="POST" action="{{ route('recipient.request.store') }}">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label>Blood Type Needed</label>
                <select name="blood_type" required>
                    <option value="">Select blood type...</option>
                    @foreach($inventory as $item)
                    <option value="{{ $item->blood_type }}" {{ old('blood_type') === $item->blood_type ? 'selected':'' }}>
                        {{ $item->blood_type }} ({{ $item->units_available }} units)
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Units Needed</label>
                <input type="number" name="units_needed" min="1" max="10" value="{{ old('units_needed', 1) }}" required>
            </div>
            <div class="form-group" style="grid-column:1/-1">
                <label>Reason / Purpose</label>
                <input type="text" name="reason" placeholder="e.g. Surgery, Emergency, Treatment" value="{{ old('reason') }}" required>
            </div>
        </div>
        <div style="margin-top:12px;padding:10px 14px;background:rgba(245,158,11,.08);border:1px solid rgba(245,158,11,.2);border-radius:4px;font-size:.75rem;color:var(--amber)">
            Rate limit: maximum 3 requests every 2 minutes.
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-red">Submit Request</button>
            <a href="{{ route('recipient.dashboard') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
