@extends('layouts.app')
@section('title', 'Donations — SanguineDonor')
@section('sidebar')
@include('admin.partials.sidebar')
@endsection
@section('content')
<div class="page-title">Donation Records</div>
<div class="page-sub">All recorded blood donations</div>
<div style="margin-bottom:16px">
    <a href="{{ route('admin.donations.create') }}" class="btn btn-red">Record New Donation</a>
</div>
<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>Donor</th><th>Blood Type</th><th>Volume</th><th>Date</th><th>Status</th><th>Action</th></tr></thead>
            <tbody>
            @forelse($donations as $d)
            <tr>
                <td><div class="donor-cell"><div class="avatar">{{ $d->donor->initials }}</div>{{ $d->donor->full_name }}</div></td>
                <td>{{ $d->blood_type }}</td>
                <td>{{ $d->volume_ml }} mL</td>
                <td>{{ \Carbon\Carbon::parse($d->donation_date)->format('M j, Y') }}</td>
                <td><span class="status status-active">{{ $d->status }}</span></td>
                <td>
                    <form method="POST" action="{{ route('admin.donations.destroy', $d->id) }}" onsubmit="return confirm('Remove this record?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-ghost btn-sm">Remove</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="color:var(--muted);text-align:center;padding:24px">No donations recorded yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
