@extends('layouts.app')
@section('title', 'Donors — SanguineDonor')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="page-title">All Donors</div>
<div class="page-sub">Manage registered blood donors</div>

<div style="margin-bottom:16px">
    <a href="{{ route('admin.donors.create') }}" class="btn btn-red">Register New Donor</a>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Name</th><th>Blood Type</th><th>Contact</th><th>Last Donation</th><th>Donations</th><th>Status</th><th>Verification</th><th>Actions</th></tr>
            </thead>
            <tbody>
            @forelse($donors as $d)
            <tr>
                <td>
                    <div class="donor-cell">
                        <div class="avatar">{{ $d->initials }}</div>
                        <div>
                            <div style="font-weight:500">{{ $d->full_name }}</div>
                            <div style="font-size:.72rem;color:var(--muted)">{{ $d->email }}</div>
                        </div>
                    </div>
                </td>
                <td><strong>{{ $d->blood_type }}</strong></td>
                <td>{{ $d->contact_number }}</td>
                <td>{{ $d->last_donation_date ? \Carbon\Carbon::parse($d->last_donation_date)->format('M j, Y') : '—' }}</td>
                <td>{{ $d->total_donations }}</td>
                <td><span class="status status-{{ strtolower($d->status) }}">{{ $d->status }}</span></td>
                <td>
                    @if($d->user)
                        <span class="status {{ $d->user->verification_status === 'approved' ? 'status-active' : ($d->user->verification_status === 'declined' ? 'status-inactive' : 'status-pending') }}">
                            {{ ucfirst($d->user->verification_status) }}
                        </span>
                    @else
                        <span style="color:var(--muted);font-size:.75rem">Walk-in</span>
                    @endif
                </td>
                <td style="display:flex;gap:4px;flex-wrap:wrap">
                    @if($d->user && $d->user->verification_status === 'pending')
                    <form method="POST" action="{{ route('admin.donors.approve', $d->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-red btn-sm">Approve</button>
                    </form>
                    <form method="POST" action="{{ route('admin.donors.decline', $d->id) }}" onsubmit="return confirm('Decline this donor?')">
                        @csrf
                        <button type="submit" class="btn btn-ghost btn-sm">Decline</button>
                    </form>
                    @else
                    <a href="{{ route('admin.donors.edit', $d->id) }}" class="btn btn-outline btn-sm">Edit</a>
                    <form method="POST" action="{{ route('admin.donors.destroy', $d->id) }}" style="display:inline" onsubmit="return confirm('Remove donor?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-ghost btn-sm">Remove</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="color:var(--muted);text-align:center;padding:24px">No donors registered yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection