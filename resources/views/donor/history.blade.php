@extends('layouts.app')
@section('title', 'Donation History — SanguineDonor')
@section('sidebar')
<div class="nav-section">Donor</div>
<a href="{{ route('donor.dashboard') }}"><i class="sidebar-icon">&#9632;</i> My Dashboard</a>
<a href="{{ route('donor.schedule') }}"><i class="sidebar-icon">&#9776;</i> Schedule Donation</a>
<a href="{{ route('donor.history') }}" class="active"><i class="sidebar-icon">&#9679;</i> Donation History</a>
<a href="{{ route('donor.profile') }}"><i class="sidebar-icon">&#43;</i> My Profile</a>
@endsection
@section('content')
<div class="page-title">Donation History</div>
<div class="page-sub">All your past blood donations</div>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-label">Total Donations</div>
        <div class="stat-value">{{ $donations->count() }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Total Volume</div>
        <div class="stat-value" style="font-size:1.3rem">{{ number_format($donations->sum('volume_ml')) }} mL</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Lives Impacted</div>
        <div class="stat-value">{{ $donations->count() * 3 }}</div>
    </div>
</div>

<div class="card">
    @if($donations->count())
    <div class="table-wrap">
        <table>
            <thead><tr><th>Date</th><th>Blood Type</th><th>Volume</th><th>Status</th></tr></thead>
            <tbody>
            @foreach($donations as $d)
            <tr>
                <td>{{ \Carbon\Carbon::parse($d->donation_date)->format('M j, Y') }}</td>
                <td><strong>{{ $d->blood_type }}</strong></td>
                <td>{{ $d->volume_ml }} mL</td>
                <td><span class="status status-active">{{ $d->status }}</span></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div style="color:var(--muted);font-size:.82rem;text-align:center;padding:32px">No donation records yet.</div>
    @endif
</div>
@endsection
