@extends('layouts.app')
@section('title', 'My Requests — SanguineDonor')
@section('sidebar')
<div class="nav-section">Recipient</div>
<a href="{{ route('recipient.dashboard') }}"><i class="sidebar-icon">&#9632;</i> My Dashboard</a>
<a href="{{ route('recipient.request') }}"><i class="sidebar-icon">&#9679;</i> Request Blood</a>
<a href="{{ route('recipient.my-requests') }}" class="active"><i class="sidebar-icon">&#9776;</i> My Requests</a>
@endsection
@section('content')
<div class="page-title">My Requests</div>
<div class="page-sub">Track the status of your blood requests</div>

<div style="margin-bottom:16px">
    <a href="{{ route('recipient.request') }}" class="btn btn-red">New Request</a>
</div>

<div class="card">
    @if($requests->count())
    <div class="table-wrap">
        <table>
            <thead><tr><th>Date</th><th>Blood Type</th><th>Units</th><th>Reason</th><th>Status</th></tr></thead>
            <tbody>
            @foreach($requests as $r)
            <tr>
                <td>{{ $r->created_at->format('M j, Y') }}</td>
                <td><strong>{{ $r->blood_type }}</strong></td>
                <td>{{ $r->units_needed }}</td>
                <td>{{ $r->reason }}</td>
                <td><span class="status {{ $r->status === 'Approved' ? 'status-active' : ($r->status === 'Rejected' ? 'status-inactive' : 'status-pending') }}">{{ $r->status }}</span></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div style="color:var(--muted);font-size:.82rem;text-align:center;padding:32px">
        No requests yet. <a href="{{ route('recipient.request') }}" style="color:var(--red-l)">Submit a request</a>.
    </div>
    @endif
</div>
@endsection
