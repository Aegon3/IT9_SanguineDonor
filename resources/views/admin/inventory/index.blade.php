@extends('layouts.app')
@section('title', 'Blood Inventory — SanguineDonor')

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div style="margin-bottom:24px">
    <div class="page-title">Blood Inventory</div>
    <div class="page-sub">Current blood stock levels and expiry tracking</div>
</div>

@if(session('success'))
<div style="background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);color:#22c55e;padding:10px 14px;border-radius:6px;font-size:.8rem;margin-bottom:20px">
    {{ session('success') }}
</div>
@endif

{{-- Summary bar --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:28px">
    @php
        $critical = $inventory->filter(fn($i) => $i->status_label === 'Critical')->count();
        $monitor  = $inventory->filter(fn($i) => $i->status_label === 'Monitor')->count();
        $sufficient = $inventory->filter(fn($i) => $i->status_label === 'Sufficient')->count();
        $totalUnits = $inventory->sum('units_available');
    @endphp
    <div style="background:rgba(239,68,68,.07);border:1px solid rgba(239,68,68,.2);border-radius:10px;padding:16px 20px;display:flex;align-items:center;gap:14px">
        <div style="width:40px;height:40px;background:rgba(239,68,68,.15);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0";font-weight:700;color:#ef4444">!</div>
        <div>
            <div style="font-size:1.5rem;font-weight:700;color:#ef4444">{{ $critical }}</div>
            <div style="font-size:.72rem;text-transform:uppercase;letter-spacing:.08em;color:var(--muted)">Critical Types</div>
        </div>
    </div>
    <div style="background:rgba(245,158,11,.07);border:1px solid rgba(245,158,11,.2);border-radius:10px;padding:16px 20px;display:flex;align-items:center;gap:14px">
        <div style="width:40px;height:40px;background:rgba(245,158,11,.15);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0";font-weight:700;color:#f59e0b">~</div>
        <div>
            <div style="font-size:1.5rem;font-weight:700;color:#f59e0b">{{ $monitor }}</div>
            <div style="font-size:.72rem;text-transform:uppercase;letter-spacing:.08em;color:var(--muted)">Needs Monitoring</div>
        </div>
    </div>
    <div style="background:rgba(34,197,94,.07);border:1px solid rgba(34,197,94,.2);border-radius:10px;padding:16px 20px;display:flex;align-items:center;gap:14px">
        <div style="width:40px;height:40px;background:rgba(34,197,94,.15);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0";font-weight:700;color:#22c55e">✓</div>
        <div>
            <div style="font-size:1.5rem;font-weight:700;color:#22c55e">{{ number_format($totalUnits) }}</div>
            <div style="font-size:.72rem;text-transform:uppercase;letter-spacing:.08em;color:var(--muted)">Total Units Available</div>
        </div>
    </div>
</div>

{{-- Blood type cards --}}
<div style="display:grid;grid-template-columns:repeat(2,1fr);gap:16px">
    @foreach($inventory as $item)
    @php
        $pct   = $item->percentage;
        $color = $item->status_color;
        $label = $item->status_label;
        $bgColor = $label === 'Critical' ? 'rgba(239,68,68,.06)' : ($label === 'Monitor' ? 'rgba(245,158,11,.06)' : 'rgba(34,197,94,.04)');
        $borderColor = $label === 'Critical' ? 'rgba(239,68,68,.25)' : ($label === 'Monitor' ? 'rgba(245,158,11,.25)' : 'rgba(34,197,94,.15)');
    @endphp
    <div style="background:{{ $bgColor }};border:1px solid {{ $borderColor }};border-radius:12px;padding:20px 24px;position:relative;overflow:hidden">
        {{-- Decorative blood type watermark --}}
        <div style="position:absolute;right:16px;top:50%;transform:translateY(-50%);font-size:4rem;font-weight:800;color:{{ $color }};opacity:.07;pointer-events:none;line-height:1">{{ $item->blood_type }}</div>

        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
            <div style="display:flex;align-items:center;gap:12px">
                <div style="width:44px;height:44px;background:{{ $color }}22;border:2px solid {{ $color }}44;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1rem;font-weight:800;color:{{ $color }}">{{ $item->blood_type }}</div>
                <div>
                    <div style="font-size:1.5rem;font-weight:700;color:var(--text)">{{ number_format($item->units_available) }} <span style="font-size:.75rem;font-weight:400;color:var(--muted)">units</span></div>
                    <div style="font-size:.72rem;color:var(--muted)">of {{ number_format($item->capacity) }} capacity</div>
                </div>
            </div>
            <div style="display:flex;flex-direction:column;align-items:flex-end;gap:8px">
                <span style="background:{{ $color }}22;color:{{ $color }};border:1px solid {{ $color }}44;padding:3px 10px;border-radius:20px;font-size:.7rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em">{{ $label }}</span>
                <a href="{{ route('admin.inventory.edit', $item->id) }}" class="btn btn-outline btn-sm">Edit</a>
            </div>
        </div>

        {{-- Progress bar --}}
        <div style="background:rgba(255,255,255,.06);border-radius:99px;height:8px;overflow:hidden;margin-bottom:8px">
            <div style="height:100%;width:{{ $pct }}%;background:{{ $color }};border-radius:99px;transition:width .3s ease"></div>
        </div>
        <div style="display:flex;justify-content:space-between;font-size:.7rem;color:var(--muted)">
            <span>{{ $pct }}% filled</span>
            @if($item->expiry_date)
            <span>Expires: {{ \Carbon\Carbon::parse($item->expiry_date)->format('M j, Y') }}</span>
            @else
            <span>No expiry set</span>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endsection