<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\BloodInventory;
use App\Models\Donor;
use App\Models\BloodRequest;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $totalDonations  = Donation::count();
        $totalVolume     = Donation::sum('volume_ml');
        $inventory       = BloodInventory::orderBy('blood_type')->get();
        $donationsByType = Donation::select('blood_type', \DB::raw('count(*) as total'))
            ->groupBy('blood_type')->get();
        $recentDonations = Donation::with('donor')->orderByDesc('donation_date')->limit(10)->get();
        $totalRequests   = BloodRequest::count();
        $approvedRequests = BloodRequest::where('status','Approved')->count();
        $topDonors       = Donor::orderByDesc('total_donations')->limit(5)->get();

        return view('admin.reports.index', compact(
            'totalDonations','totalVolume','inventory',
            'donationsByType','recentDonations',
            'totalRequests','approvedRequests','topDonors'
        ));
    }
}
