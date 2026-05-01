<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use App\Models\BloodInventory;
use App\Models\User;
use App\Models\BloodRequest;
use App\Models\Donation;
use App\Models\Appointment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDonors        = Donor::count();
        $activeDonors       = Donor::where('status','Active')->count();
        $pendingDonors      = Donor::whereHas('user', fn($q) => $q->where('verification_status','pending'))->count();
        $unitsAvailable     = BloodInventory::sum('units_available');
        $pendingRequests    = BloodRequest::where('status','Pending')->count();
        $pendingRecipients  = User::where('role','recipient')->where('verification_status','pending')->count();
        $todayDonations     = Donation::whereDate('donation_date', Carbon::today())->count();
        $monthDonations     = Donation::whereMonth('donation_date', Carbon::now()->month)->count();
        $criticalInventory  = BloodInventory::all()->filter(fn($i) => $i->status_label === 'Critical');
        $inventory          = BloodInventory::orderBy('blood_type')->get();
        $recentDonors       = Donor::with('user')->orderByDesc('created_at')->limit(5)->get();
        $upcomingAppts      = Appointment::with('donor')->whereIn('status',['Pending','Confirmed'])
                                ->where('appointment_date','>=',Carbon::today())
                                ->orderBy('appointment_date')->limit(5)->get();
        $recentActivity     = collect()
            ->merge(Donation::with('donor')->orderByDesc('created_at')->limit(4)->get()->map(fn($d) => [
                'type'  => 'donation',
                'label' => ($d->donor->full_name ?? 'Unknown') . ' donated ' . $d->blood_type,
                'time'  => $d->created_at,
                'color' => '#22c55e',
            ]))
            ->merge(BloodRequest::with('user')->orderByDesc('created_at')->limit(4)->get()->map(fn($r) => [
                'type'  => 'request',
                'label' => ($r->user->name ?? 'Unknown') . ' requested ' . $r->blood_type,
                'time'  => $r->created_at,
                'color' => '#f59e0b',
            ]))
            ->merge(Donor::with('user')->orderByDesc('created_at')->limit(3)->get()->map(fn($d) => [
                'type'  => 'donor',
                'label' => $d->full_name . ' registered as donor',
                'time'  => $d->created_at,
                'color' => '#e74c3c',
            ]))
            ->sortByDesc('time')
            ->take(8)
            ->values();

        return view('admin.dashboard', compact(
            'totalDonors','activeDonors','pendingDonors',
            'unitsAvailable','pendingRequests','pendingRecipients',
            'todayDonations','monthDonations','criticalInventory',
            'inventory','recentDonors','upcomingAppts','recentActivity'
        ));
    }
}