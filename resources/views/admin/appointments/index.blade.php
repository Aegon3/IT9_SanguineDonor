@extends('layouts.app')
@section('title', 'Appointments — SanguineDonor')
@section('sidebar')
@include('admin.partials.sidebar')
@endsection
@section('content')
<div class="page-title">Appointments</div>
<div class="page-sub">Manage all donor appointments</div>
<div class="card">
    <div class="table-wrap">
        <table>
            <thead><tr><th>Donor</th><th>Blood Type</th><th>Date</th><th>Time</th><th>Location</th><th>Status</th><th>Action</th></tr></thead>
            <tbody>
            @forelse($appointments as $a)
            <tr>
                <td>{{ $a->donor->full_name }}</td>
                <td>{{ $a->donor->blood_type }}</td>
                <td>{{ \Carbon\Carbon::parse($a->appointment_date)->format('M j, Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($a->appointment_time)->format('g:i A') }}</td>
                <td style="font-size:.78rem">{{ $a->location }}</td>
                <td><span class="status status-{{ strtolower($a->status) }}">{{ $a->status }}</span></td>
                <td>
                    <form method="POST" action="{{ route('admin.appointments.update', $a->id) }}" style="display:flex;gap:4px">
                        @csrf
                        <select name="status" style="padding:4px 8px;background:var(--bg);border:1px solid var(--border2);border-radius:4px;color:var(--text);font-size:.75rem">
                            @foreach(['Pending','Confirmed','Completed','Cancelled'] as $s)
                            <option value="{{ $s }}" {{ $a->status === $s ? 'selected':'' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-red btn-sm">Update</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="color:var(--muted);text-align:center;padding:24px">No appointments yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
