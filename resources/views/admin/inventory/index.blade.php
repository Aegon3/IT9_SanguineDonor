@extends('layouts.app')
@section('title', 'Blood Inventory — SanguineDonor')

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
<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:4px">
    <div>
        <div class="page-title">Blood Inventory</div>
        <div class="page-sub">Current blood stock levels and expiry tracking</div>
    </div>
    <a href="#" class="btn btn-red" style="margin-top:4px">+ Update Stock</a>
</div>

<div class="blood-grid">
    @foreach($inventory as $item)
    @php
        $pct   = $item->percentage;
        $color = $item->status_color;
        $label = $item->status_label;
    @endphp
    <div class="blood-card">
        <div style="display:flex;align-items:center;justify-content:space-between">
            <div style="flex:1">
                <div class="blood-type-label">{{ $item->blood_type }}</div>
                <div class="blood-units">{{ number_format($item->units_available) }} units &mdash; of {{ number_format($item->capacity) }} capacity</div>
                <div class="progress-bar-wrap">
                    <div class="progress-bar" style="width:{{ $pct }}%;background:{{ $color }}"></div>
                </div>
                <span class="blood-status" style="background:{{ $color }}22;color:{{ $color }}">{{ $label }}</span>
            </div>
            <div style="margin-left:24px;flex-shrink:0">
                <a href="{{ route('admin.inventory.edit', $item->id) }}" class="btn btn-outline btn-sm">Update</a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
