@extends('layouts.app')
@section('title', 'Admin Dashboard — SanguineDonor')
@section('sidebar')
@include('admin.partials.sidebar')
@endsection
@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px">
    <div>
        <div class="page-title">Dashboard</div>
        <div class="page-sub">{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</div>
    </div>
    @if($criticalInventory->count())
    <div style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.3);border-radius:8px;padding:8px 14px;display:flex;align-items:center;gap:8px">
        <span style="width:8px;height:8px;background:#ef4444;border-radius:50%;animation:pulse 1.5s infinite"></span>
        <span style="font-size:.75rem;color:#ef4444;font-weight:500">{{ $criticalInventory->count() }} blood type{{ $criticalInventory->count() > 1 ? 's':'' }} critically low</span>
    </div>
    @endif
</div>

<style>
@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.3} }
</style>

{{-- Top stat row --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px">
    @php
    $stats = [
        ['label'=>'Total Donors',       'value'=>$totalDonors,      'sub'=>$activeDonors.' active',             'color'=>'#e74c3c', 'link'=>route('admin.donors.index')],
        ['label'=>'Pending Verifications','value'=>$pendingDonors + $pendingRecipients, 'sub'=>$pendingDonors.' donors · '.$pendingRecipients.' recipients', 'color'=>'#f59e0b', 'link'=>route('admin.donors.index')],
        ['label'=>'Blood Requests',     'value'=>$pendingRequests,  'sub'=>'awaiting review',                   'color'=>'#a78bfa', 'link'=>route('admin.blood-requests.index')],
        ['label'=>'Units Available',    'value'=>number_format($unitsAvailable), 'sub'=>$criticalInventory->count().' types critical', 'color'=>'#22c55e', 'link'=>route('admin.inventory.index')],
    ];
    @endphp
    @foreach($stats as $s)
    <a href="{{ $s['link'] }}" style="text-decoration:none">
    <div style="background:var(--surface);border:1px solid var(--border);border-radius:12px;padding:18px 20px;position:relative;overflow:hidden;transition:border-color .15s;cursor:pointer"
         onmouseover="this.style.borderColor='{{ $s['color'] }}55'" onmouseout="this.style.borderColor='var(--border)'">
        <div style="position:absolute;top:0;left:0;width:3px;height:100%;background:{{ $s['color'] }};border-radius:3px 0 0 3px"></div>
        <div style="font-size:.65rem;text-transform:uppercase;letter-spacing:.1em;color:var(--muted);margin-bottom:8px">{{ $s['label'] }}</div>
        <div style="font-size:1.8rem;font-weight:700;color:var(--text);line-height:1;margin-bottom:4px">{{ $s['value'] }}</div>
        <div style="font-size:.72rem;color:{{ $s['color'] }}">{{ $s['sub'] }}</div>
    </div>
    </a>
    @endforeach
</div>

{{-- Second row: donations today + month --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:20px">
    <div style="background:var(--surface);border:1px solid var(--border);border-radius:12px;padding:18px 20px">
        <div style="font-size:.65rem;text-transform:uppercase;letter-spacing:.1em;color:var(--muted);margin-bottom:6px">Donations Today</div>
        <div style="font-size:2rem;font-weight:700;color:#22c55e">{{ $todayDonations }}</div>
        <div style="font-size:.72rem;color:var(--muted);margin-top:4px">{{ $monthDonations }} this month</div>
    </div>
    {{-- Critical inventory alert --}}
    <div style="background:var(--surface);border:1px solid {{ $criticalInventory->count() ? 'rgba(239,68,68,.3)' : 'var(--border)' }};border-radius:12px;padding:18px 20px">
        <div style="font-size:.65rem;text-transform:uppercase;letter-spacing:.1em;color:var(--muted);margin-bottom:10px">Inventory Alerts</div>
        @if($criticalInventory->count())
        <div style="display:flex;flex-wrap:wrap;gap:6px">
            @foreach($criticalInventory as $c)
            <span style="background:rgba(239,68,68,.12);border:1px solid rgba(239,68,68,.3);color:#ef4444;padding:4px 10px;border-radius:6px;font-size:.78rem;font-weight:700">
                {{ $c->blood_type }} — {{ $c->units_available }} units
            </span>
            @endforeach
        </div>
        @else
        <div style="font-size:.82rem;color:#22c55e">All blood types at safe levels</div>
        @endif
    </div>
</div>

{{-- Blood inventory mini bars --}}
<div class="card" style="margin-bottom:20px">
    <div class="card-header">
        <span class="card-title">Blood Inventory Overview</span>
        <a href="{{ route('admin.inventory.index') }}" class="view-all">Manage &rarr;</a>
    </div>
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:10px">
        @foreach($inventory as $item)
        <div style="background:var(--bg);border:1px solid var(--border);border-radius:8px;padding:12px 14px">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px">
                <span style="font-weight:700;color:{{ $item->status_color }}">{{ $item->blood_type }}</span>
                <span style="font-size:.68rem;color:var(--muted)">{{ $item->percentage }}%</span>
            </div>
            <div style="background:rgba(255,255,255,.06);border-radius:99px;height:5px;overflow:hidden">
                <div style="height:100%;width:{{ $item->percentage }}%;background:{{ $item->status_color }};border-radius:99px"></div>
            </div>
            <div style="font-size:.68rem;color:var(--muted);margin-top:5px">{{ number_format($item->units_available) }} units</div>
        </div>
        @endforeach
    </div>
</div>

{{-- Bottom 3-col layout --}}
<div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px">

    {{-- Recent donors --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">Recent Donors</span>
            <a href="{{ route('admin.donors.index') }}" class="view-all">All &rarr;</a>
        </div>
        <div style="display:flex;flex-direction:column;gap:10px">
        @forelse($recentDonors as $d)
        <div style="display:flex;align-items:center;gap:10px">
            <div class="avatar">{{ $d->initials }}</div>
            <div style="flex:1;min-width:0">
                <div style="font-size:.8rem;font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $d->full_name }}</div>
                <div style="font-size:.68rem;color:var(--muted)">{{ $d->blood_type }} &middot; {{ $d->created_at->diffForHumans() }}</div>
            </div>
            <span class="status status-{{ strtolower($d->status) }}" style="font-size:.65rem">{{ $d->status }}</span>
        </div>
        @empty
        <div style="color:var(--muted);font-size:.8rem;text-align:center;padding:16px">No donors yet.</div>
        @endforelse
        </div>
    </div>

    {{-- Upcoming appointments --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">Upcoming Appointments</span>
            <a href="{{ route('admin.appointments.index') }}" class="view-all">All &rarr;</a>
        </div>
        <div style="display:flex;flex-direction:column;gap:10px">
        @forelse($upcomingAppts as $a)
        <div style="display:flex;align-items:center;gap:10px">
            <div style="width:36px;height:36px;background:var(--red-dim);border:1px solid var(--red-dim2);border-radius:8px;display:flex;flex-direction:column;align-items:center;justify-content:center;flex-shrink:0">
                <span style="font-size:.55rem;color:var(--red-l);text-transform:uppercase;line-height:1">{{ \Carbon\Carbon::parse($a->appointment_date)->format('M') }}</span>
                <span style="font-size:.85rem;font-weight:700;color:var(--red-l);line-height:1">{{ \Carbon\Carbon::parse($a->appointment_date)->format('d') }}</span>
            </div>
            <div style="flex:1;min-width:0">
                <div style="font-size:.8rem;font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $a->donor->full_name }}</div>
                <div style="font-size:.68rem;color:var(--muted)">{{ \Carbon\Carbon::parse($a->appointment_time)->format('g:i A') }}</div>
            </div>
            <span class="status status-{{ strtolower($a->status) }}" style="font-size:.65rem">{{ $a->status }}</span>
        </div>
        @empty
        <div style="color:var(--muted);font-size:.8rem;text-align:center;padding:16px">No upcoming appointments.</div>
        @endforelse
        </div>
    </div>

    {{-- Activity feed --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">Recent Activity</span>
        </div>
        <div style="display:flex;flex-direction:column;gap:0">
        @forelse($recentActivity as $act)
        <div style="display:flex;align-items:flex-start;gap:10px;padding:8px 0;border-bottom:1px solid var(--border)">
            <div style="width:8px;height:8px;background:{{ $act['color'] }};border-radius:50%;flex-shrink:0;margin-top:5px"></div>
            <div style="flex:1">
                <div style="font-size:.78rem;color:var(--text)">{{ $act['label'] }}</div>
                <div style="font-size:.65rem;color:var(--muted)">{{ \Carbon\Carbon::parse($act['time'])->diffForHumans() }}</div>
            </div>
        </div>
        @empty
        <div style="color:var(--muted);font-size:.8rem;text-align:center;padding:16px">No recent activity.</div>
        @endforelse
        </div>
    </div>

</div>
@endsection