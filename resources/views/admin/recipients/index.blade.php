@extends('layouts.app')
@section('title', 'Recipients — SanguineDonor')
@section('sidebar')
@include('admin.partials.sidebar')
@endsection
@section('content')
<div class="page-title">Recipients</div>
<div class="page-sub">Approve or decline recipient accounts</div>
<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>Name</th><th>Username</th><th>Email</th><th>Registered</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($recipients as $r)
            <tr>
                <td>{{ $r->name }}</td>
                <td>{{ $r->username }}</td>
                <td>{{ $r->email ?? '—' }}</td>
                <td>{{ $r->created_at->format('M j, Y') }}</td>
                <td><span class="status {{ $r->verification_status === 'approved' ? 'status-active' : ($r->verification_status === 'declined' ? 'status-inactive' : 'status-pending') }}">{{ ucfirst($r->verification_status) }}</span></td>
                <td style="display:flex;gap:6px;flex-wrap:wrap">
                    @if($r->verification_status !== 'approved')
                    <form method="POST" action="{{ route('admin.recipients.approve', $r->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-red btn-sm">Approve</button>
                    </form>
                    @endif
                    @if($r->verification_status !== 'declined')
                    <form method="POST" action="{{ route('admin.recipients.decline', $r->id) }}" onsubmit="return confirm('Decline this recipient?')">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Decline</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="color:var(--muted);text-align:center;padding:24px">No recipients yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
