@extends('layouts.app')
@section('title', 'Update Inventory — SanguineDonor')

@section('sidebar')
@include('admin.partials.sidebar')
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