<?php

namespace App\Http\Controllers\Recipient;

use App\Http\Controllers\Controller;
use App\Models\BloodInventory;
use App\Models\BloodRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RecipientDashboardController extends Controller
{
    public function index()
    {
        $inventory  = BloodInventory::orderBy('blood_type')->get();
        $myRequests = BloodRequest::where('user_id', auth()->id())
            ->orderByDesc('created_at')->limit(3)->get();
        $approved   = auth()->user()->isApproved();
        return view('recipient.dashboard', compact('inventory','myRequests','approved'));
    }

    public function requestBlood()
    {
        $inventory = BloodInventory::orderBy('blood_type')->get();
        return view('recipient.request', compact('inventory'));
    }

    public function storeRequest(Request $request)
    {
        $request->validate([
            'blood_type'   => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'units_needed' => 'required|integer|min:1|max:10',
            'reason'       => 'required|string|max:500',
        ]);

        // Rate limit: 3 requests per 2 minutes
        $key   = 'blood_request_' . auth()->id();
        $limit = 3;
        $decay = 120; // 2 minutes in seconds

        $attempts = Cache::get($key, 0);
        if ($attempts >= $limit) {
            return back()->withErrors(['rate_limit' => 'You have reached the request limit (3 per 2 minutes). Please wait before submitting again.'])->withInput();
        }
        Cache::put($key, $attempts + 1, $decay);

        $inventory = BloodInventory::where('blood_type', $request->blood_type)->first();
        if (!$inventory || $inventory->units_available < $request->units_needed) {
            return back()->withErrors(['blood_type' => 'Insufficient stock for the selected blood type.'])->withInput();
        }

        BloodRequest::create([
            'user_id'      => auth()->id(),
            'blood_type'   => $request->blood_type,
            'units_needed' => $request->units_needed,
            'reason'       => $request->reason,
            'status'       => 'Pending',
        ]);

        return redirect()->route('recipient.my-requests')->with('success', 'Blood request submitted. Awaiting admin approval.');
    }

    public function myRequests()
    {
        $requests = BloodRequest::where('user_id', auth()->id())
            ->orderByDesc('created_at')->get();
        return view('recipient.my-requests', compact('requests'));
    }
}
