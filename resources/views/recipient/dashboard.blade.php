@extends('layouts.app')
@section('title', 'My Dashboard — SanguineDonor')
@section('sidebar')
<div class="nav-section">Recipient</div>
<a href="{{ route('recipient.dashboard') }}" class="{{ request()->routeIs('recipient.dashboard') ? 'active':'' }}"><i class="sidebar-icon">&#9632;</i> My Dashboard</a>
@if(auth()->user()->isApproved())
<a href="{{ route('recipient.request') }}" class="{{ request()->routeIs('recipient.request') ? 'active':'' }}"><i class="sidebar-icon">&#9679;</i> Request Blood</a>
<a href="{{ route('recipient.my-requests') }}" class="{{ request()->routeIs('recipient.my-requests') ? 'active':'' }}"><i class="sidebar-icon">&#9776;</i> My Requests</a>
@endif
@endsection
@section('content')
<div class="page-title">My Dashboard</div>
<div class="page-sub">Overview of available blood inventory</div>

@if(!auth()->user()->isApproved())
<div class="card" style="margin-bottom:20px">
    <div style="text-align:center;padding:32px 20px">
        @if(auth()->user()->verification_status === 'declined')
        <div style="font-size:1rem;font-weight:600;color:var(--red-l);margin-bottom:8px">Account Declined</div>
        <div style="font-size:.82rem;color:var(--muted)">Your account has been declined by an admin. Please contact the blood donation center for assistance.</div>
        @else
        <div style="font-size:1rem;font-weight:600;color:var(--amber);margin-bottom:8px">Pending Approval</div>
        <div style="font-size:.82rem;color:var(--muted)">Your account is awaiting admin approval. Once approved, you will be able to request blood and access all features.</div>
        @endif
    </div>
</div>
@endif

<div class="card">
    <div class="card-header">
        <span class="card-title">Available Blood Types</span>
        @if(auth()->user()->isApproved())
        <a href="{{ route('recipient.request') }}" class="view-all">Request Blood &rarr;</a>
        @endif
    </div>
    <div style="display:flex;flex-direction:column;gap:8px">
        @foreach($inventory as $item)
        @php $low = $item->units_available < 100; @endphp
        <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 16px;background:{{ $low ? 'rgba(192,57,43,.08)':'var(--bg)' }};border:1px solid {{ $low ? 'rgba(192,57,43,.3)':'var(--border)' }};border-radius:4px">
            <div>
                <span style="font-size:1rem;font-weight:700;color:var(--text)">{{ $item->blood_type }}</span>
                <span style="font-size:.75rem;color:var(--muted);margin-left:8px">{{ number_format($item->units_available) }} units available</span>
            </div>
            @if($low)
            <span class="status status-pending">Low</span>
            @else
            <span class="status status-active">Sufficient</span>
            @endif
        </div>
        @endforeach
    </div>
</div>

@if(auth()->user()->isApproved() && $myRequests->count())
<div class="card">
    <div class="card-header">
        <span class="card-title">Recent Requests</span>
        <a href="{{ route('recipient.my-requests') }}" class="view-all">View all &rarr;</a>
    </div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Blood Type</th><th>Units</th><th>Status</th><th>Date</th></tr></thead>
            <tbody>
            @foreach($myRequests as $r)
            <tr>
                <td><strong>{{ $r->blood_type }}</strong></td>
                <td>{{ $r->units_needed }}</td>
                <td><span class="status {{ $r->status === 'Approved' ? 'status-active' : ($r->status === 'Rejected' ? 'status-inactive' : 'status-pending') }}">{{ $r->status }}</span></td>
                <td>{{ $r->created_at->format('M j, Y') }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
