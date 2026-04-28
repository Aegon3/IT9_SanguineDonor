<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Donor;
use App\Models\Appointment;
use App\Models\BloodInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Donation::with('donor')->orderByDesc('donation_date')->get();
        return view('admin.donations.index', compact('donations'));
    }

    public function create()
    {
        $donors       = Donor::orderBy('first_name')->get();
        $appointments = Appointment::with('donor')
            ->where('status', 'Confirmed')
            ->orderByDesc('appointment_date')
            ->get();
        return view('admin.donations.create', compact('donors','appointments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'donor_id'       => 'required|exists:donors,id',
            'donation_date'  => 'required|date',
            'blood_type'     => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'volume_ml'      => 'required|integer|min:100|max:600',
            'appointment_id' => 'nullable|exists:appointments,id',
        ]);

        DB::transaction(function () use ($request) {
            $donation = Donation::create([
                'donor_id'       => $request->donor_id,
                'appointment_id' => $request->appointment_id,
                'donation_date'  => $request->donation_date,
                'blood_type'     => $request->blood_type,
                'volume_ml'      => $request->volume_ml,
                'status'         => 'Completed',
            ]);

            // Update donor total donations and last donation date
            $donor = Donor::find($request->donor_id);
            $donor->increment('total_donations');
            $donor->update(['last_donation_date' => $request->donation_date]);

            // Update blood inventory
            BloodInventory::where('blood_type', $request->blood_type)
                ->increment('units_available', 1);

            // Mark appointment as completed if linked
            if ($request->appointment_id) {
                Appointment::find($request->appointment_id)
                    ->update(['status' => 'Completed']);
            }
        });

        return redirect()->route('admin.donations.index')->with('success', 'Donation recorded successfully.');
    }

    public function destroy(Donation $donation)
    {
        DB::transaction(function () use ($donation) {
            $donor = $donation->donor;
            if ($donor->total_donations > 0) {
                $donor->decrement('total_donations');
            }
            BloodInventory::where('blood_type', $donation->blood_type)
                ->decrement('units_available', 1);
            $donation->delete();
        });
        return back()->with('success', 'Donation record removed.');
    }
}
