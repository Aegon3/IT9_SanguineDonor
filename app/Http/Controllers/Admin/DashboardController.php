<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use App\Models\BloodInventory;
use App\Models\User;
use App\Models\BloodRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDonors     = Donor::count();
        $unitsAvailable  = BloodInventory::sum('units_available');
        $pendingRequests = BloodRequest::where('status','Pending')->count();
        $pendingRecipients = User::where('role','recipient')->where('verification_status','pending')->count();
        $recentDonors    = Donor::orderByDesc('created_at')->limit(5)->get();

        return view('admin.dashboard', compact(
            'totalDonors','unitsAvailable','pendingRequests',
            'pendingRecipients','recentDonors'
        ));
    }
}
