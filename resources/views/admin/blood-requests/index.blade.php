@extends('layouts.app')
@section('title', 'Blood Requests — SanguineDonor')
@section('sidebar')
@include('admin.partials.sidebar')
@endsection
@section('content')
<div class="page-title">Blood Requests</div>
<div class="page-sub">All recipient blood requests — approve or reject</div>
<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>Recipient</th><th>Blood Type</th><th>Units</th><th>Reason</th><th>Date</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($requests as $r)
            <tr>
                <td>{{ $r->user->name }}</td>
                <td><strong>{{ $r->blood_type }}</strong></td>
                <td>{{ $r->units_needed }}</td>
                <td style="font-size:.78rem">{{ $r->reason }}</td>
                <td>{{ $r->created_at->format('M j, Y') }}</td>
                <td><span class="status {{ $r->status === 'Approved' ? 'status-active' : ($r->status === 'Rejected' ? 'status-inactive' : 'status-pending') }}">{{ $r->status }}</span></td>
                <td style="display:flex;gap:6px">
                    @if($r->status === 'Pending')
                    <form method="POST" action="{{ route('admin.blood-requests.approve', $r->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-red btn-sm">Approve</button>
                    </form>
                    <form method="POST" action="{{ route('admin.blood-requests.reject', $r->id) }}" onsubmit="return confirm('Reject this request?')">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                    </form>
                    @else
                    <span style="color:var(--muted);font-size:.75rem">—</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="color:var(--muted);text-align:center;padding:24px">No blood requests yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
