<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\BloodInventory;
use App\Models\Donor;
use App\Models\BloodRequest;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', 'all');
        $from   = null;
        $to     = null;

        if ($period === 'custom') {
            $from = $request->get('from') ? Carbon::parse($request->get('from'))->startOfDay() : null;
            $to   = $request->get('to')   ? Carbon::parse($request->get('to'))->endOfDay()     : null;
        } else {
            $from = match($period) {
                'today' => Carbon::today(),
                'week'  => Carbon::now()->startOfWeek(),
                'month' => Carbon::now()->startOfMonth(),
                'year'  => Carbon::now()->startOfYear(),
                default => null,
            };
        }

        // Base queries scoped to period
        $donationQuery     = Donation::query();
        $donorQuery        = Donor::query();
        $requestQuery      = BloodRequest::query();
        $appointmentQuery  = Appointment::query();

        if ($from) {
            $donationQuery->where('donation_date', '>=', $from);
            $donorQuery->where('created_at', '>=', $from);
            $requestQuery->where('created_at', '>=', $from);
            $appointmentQuery->where('created_at', '>=', $from);
        }

        if ($to) {
            $donationQuery->where('donation_date', '<=', $to);
            $donorQuery->where('created_at', '<=', $to);
            $requestQuery->where('created_at', '<=', $to);
            $appointmentQuery->where('created_at', '<=', $to);
        }

        $totalDonations    = (clone $donationQuery)->count();
        $totalVolume       = (clone $donationQuery)->sum('volume_ml');
        $totalRequests     = (clone $requestQuery)->count();
        $approvedRequests  = (clone $requestQuery)->where('status', 'Approved')->count();
        $donorsRegistered  = (clone $donorQuery)->count();
        $totalAppointments = (clone $appointmentQuery)->count();

        $donationsByType = (clone $donationQuery)
            ->select('blood_type', DB::raw('count(*) as total'))
            ->groupBy('blood_type')
            ->get();

        $recentDonations = (clone $donationQuery)
            ->with('donor')
            ->orderByDesc('donation_date')
            ->limit(10)
            ->get();

        $inventory   = BloodInventory::orderBy('blood_type')->get();
        $topDonors   = Donor::orderByDesc('total_donations')->limit(5)->get();

        return view('admin.reports.index', compact(
            'totalDonations', 'totalVolume', 'inventory',
            'donationsByType', 'recentDonations',
            'totalRequests', 'approvedRequests',
            'donorsRegistered', 'totalAppointments',
            'topDonors', 'period'
        ));
    }
}