<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BloodRequest;
use App\Models\BloodInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BloodRequestController extends Controller
{
    public function index()
    {
        $requests = BloodRequest::with('user')->orderByDesc('created_at')->get();
        return view('admin.blood-requests.index', compact('requests'));
    }

    public function approve(BloodRequest $bloodRequest)
    {
        DB::transaction(function () use ($bloodRequest) {
            $inventory = BloodInventory::where('blood_type', $bloodRequest->blood_type)->first();
            if (!$inventory || $inventory->units_available < $bloodRequest->units_needed) {
                session()->flash('error', 'Insufficient stock to approve this request.');
                return;
            }
            $inventory->decrement('units_available', $bloodRequest->units_needed);
            $bloodRequest->update(['status' => 'Approved']);
        });
        return back()->with('success', 'Request approved and inventory updated.');
    }

    public function reject(BloodRequest $bloodRequest)
    {
        $bloodRequest->update(['status' => 'Rejected']);
        return back()->with('success', 'Request rejected.');
    }
}
