@extends('layouts.app')
@section('title', 'My Requests — SanguineDonor')
@section('sidebar')
<div class="nav-section">Recipient</div>
<a href="{{ route('recipient.dashboard') }}"><i class="sidebar-icon">&#9632;</i> My Dashboard</a>
<a href="{{ route('recipient.request') }}"><i class="sidebar-icon">&#9679;</i> Request Blood</a>
<a href="{{ route('recipient.my-requests') }}" class="active"><i class="sidebar-icon">&#9776;</i> My Requests</a>
@endsection
@section('content')

<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:24px">
    <div>
        <div class="page-title">My Requests</div>
        <div class="page-sub">Track the status of all your blood requests</div>
    </div>
    <a href="{{ route('recipient.request') }}" class="btn btn-red" style="margin-top:4px">+ New Request</a>
</div>

@if(session('success'))
<div style="background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);color:#22c55e;padding:10px 14px;border-radius:6px;font-size:.8rem;margin-bottom:20px">{{ session('success') }}</div>
@endif

@if($requests->count())

{{-- Summary pills --}}
@php
    $pending  = $requests->where('status','Pending')->count();
    $approved = $requests->where('status','Approved')->count();
    $rejected = $requests->where('status','Rejected')->count();
@endphp
<div style="display:flex;gap:10px;margin-bottom:24px;flex-wrap:wrap">
    <div style="padding:10px 18px;background:rgba(245,158,11,.08);border:1px solid rgba(245,158,11,.25);border-radius:8px;display:flex;align-items:center;gap:8px">
        <span style="width:8px;height:8px;background:#f59e0b;border-radius:50%;display:inline-block"></span>
        <span style="font-size:.78rem;color:var(--muted)">Pending</span>
        <span style="font-size:1rem;font-weight:700;color:#f59e0b">{{ $pending }}</span>
    </div>
    <div style="padding:10px 18px;background:rgba(34,197,94,.08);border:1px solid rgba(34,197,94,.25);border-radius:8px;display:flex;align-items:center;gap:8px">
        <span style="width:8px;height:8px;background:#22c55e;border-radius:50%;display:inline-block"></span>
        <span style="font-size:.78rem;color:var(--muted)">Approved</span>
        <span style="font-size:1rem;font-weight:700;color:#22c55e">{{ $approved }}</span>
    </div>
    <div style="padding:10px 18px;background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.25);border-radius:8px;display:flex;align-items:center;gap:8px">
        <span style="width:8px;height:8px;background:#ef4444;border-radius:50%;display:inline-block"></span>
        <span style="font-size:.78rem;color:var(--muted)">Rejected</span>
        <span style="font-size:1rem;font-weight:700;color:#ef4444">{{ $rejected }}</span>
    </div>
</div>

{{-- Request timeline cards --}}
<div style="display:flex;flex-direction:column;gap:12px">
@foreach($requests as $r)
@php
    $isApproved = $r->status === 'Approved';
    $isRejected = $r->status === 'Rejected';
    $isPending  = $r->status === 'Pending';
    $color      = $isApproved ? '#22c55e' : ($isRejected ? '#ef4444' : '#f59e0b');
    $bg         = $isApproved ? 'rgba(34,197,94,.05)' : ($isRejected ? 'rgba(239,68,68,.05)' : 'rgba(245,158,11,.05)');
    $border     = $isApproved ? 'rgba(34,197,94,.2)' : ($isRejected ? 'rgba(239,68,68,.2)' : 'rgba(245,158,11,.2)');
@endphp
<div style="background:{{ $bg }};border:1px solid {{ $border }};border-radius:10px;padding:18px 20px;display:flex;align-items:center;gap:20px;flex-wrap:wrap">
    {{-- Blood type badge --}}
    <div style="width:52px;height:52px;background:{{ $color }}18;border:2px solid {{ $color }}44;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:.95rem;font-weight:800;color:{{ $color }};flex-shrink:0">
        {{ $r->blood_type }}
    </div>
    {{-- Details --}}
    <div style="flex:1;min-width:180px">
        <div style="font-weight:600;font-size:.9rem;margin-bottom:3px">{{ $r->units_needed }} unit{{ $r->units_needed > 1 ? 's':'' }} of {{ $r->blood_type }}</div>
        <div style="font-size:.75rem;color:var(--muted);margin-bottom:4px">{{ $r->reason }}</div>
        <div style="font-size:.7rem;color:var(--muted)">Submitted {{ $r->created_at->format('M j, Y \a\t g:i A') }}</div>
    </div>
    {{-- Status --}}
    <div style="display:flex;flex-direction:column;align-items:flex-end;gap:4px;flex-shrink:0">
        <span style="background:{{ $color }}22;color:{{ $color }};border:1px solid {{ $color }}44;padding:4px 12px;border-radius:20px;font-size:.72rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em">
            {{ $r->status }}
        </span>
        @if($r->actioned_at)
        <span style="font-size:.68rem;color:var(--muted)">{{ $isApproved ? 'Approved' : 'Rejected' }} {{ $r->actioned_at->format('M j, Y') }}</span>
        @endif
    </div>
</div>
@endforeach
</div>

@else
<div style="text-align:center;padding:60px 20px;background:var(--surface);border:1px solid var(--border);border-radius:12px">
    <div style="font-size:2rem;margin-bottom:12px;opacity:.3">🩸</div>
    <div style="font-weight:600;margin-bottom:6px">No requests yet</div>
    <div style="font-size:.8rem;color:var(--muted);margin-bottom:20px">Your blood requests will appear here once submitted.</div>
    <a href="{{ route('recipient.request') }}" class="btn btn-red">Submit a Request</a>
</div>
@endif

@endsection