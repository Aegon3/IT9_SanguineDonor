@extends('layouts.app')
@section('title', 'Donors — SanguineDonor')
@section('sidebar')
@include('admin.partials.sidebar')
@endsection
@section('content')

<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:24px">
    <div>
        <div class="page-title">Donors</div>
        <div class="page-sub">{{ $donors->count() }} donor{{ $donors->count() !== 1 ? 's':'' }} found</div>
    </div>
    <a href="{{ route('admin.donors.create') }}" class="btn btn-red" style="margin-top:4px">+ Register Donor</a>
</div>

@if(session('success'))
<div style="background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);color:#22c55e;padding:10px 14px;border-radius:6px;font-size:.8rem;margin-bottom:16px">{{ session('success') }}</div>
@endif

{{-- Search & Filter bar --}}
<form method="GET" action="{{ route('admin.donors.index') }}">
<div style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap;align-items:center">
    {{-- Search --}}
    <div style="flex:1;min-width:200px;position:relative">
        <span style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:.85rem">&#9906;</span>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email..."
            style="width:100%;padding:8px 12px 8px 30px;background:var(--surface2);border:1px solid var(--border2);border-radius:8px;color:var(--text);font-size:.82rem;font-family:'Inter',sans-serif;outline:none">
    </div>
    {{-- Blood type filter --}}
    <select name="blood_type"
        style="padding:8px 12px;background:var(--surface2);border:1px solid var(--border2);border-radius:8px;color:{{ request('blood_type') ? 'var(--text)' : 'var(--muted)' }};font-size:.82rem;font-family:'Inter',sans-serif;outline:none">
        <option value="">All Blood Types</option>
        @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bt)
        <option value="{{ $bt }}" {{ request('blood_type') === $bt ? 'selected':'' }}>{{ $bt }}</option>
        @endforeach
    </select>
    {{-- Status filter --}}
    <select name="status"
        style="padding:8px 12px;background:var(--surface2);border:1px solid var(--border2);border-radius:8px;color:{{ request('status') ? 'var(--text)' : 'var(--muted)' }};font-size:.82rem;font-family:'Inter',sans-serif;outline:none">
        <option value="">All Statuses</option>
        @foreach(['Active','Pending','Inactive'] as $st)
        <option value="{{ $st }}" {{ request('status') === $st ? 'selected':'' }}>{{ $st }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-red" style="padding:8px 18px">Filter</button>
    @if(request('search') || request('blood_type') || request('status'))
    <a href="{{ route('admin.donors.index') }}" class="btn btn-ghost" style="padding:8px 14px;font-size:.78rem">Clear</a>
    @endif
</div>
</form>

{{-- Donors table --}}
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
                <td>
                    <span style="background:var(--red-dim);color:var(--red-l);border:1px solid var(--red-dim2);padding:2px 8px;border-radius:4px;font-weight:700;font-size:.8rem">{{ $d->blood_type }}</span>
                </td>
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
            <tr><td colspan="8" style="color:var(--muted);text-align:center;padding:32px">
                @if(request('search') || request('blood_type') || request('status'))
                    No donors match your search. <a href="{{ route('admin.donors.index') }}" style="color:var(--red-l)">Clear filters</a>
                @else
                    No donors registered yet.
                @endif
            </td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection