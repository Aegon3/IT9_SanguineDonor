<?php

namespace App\Http\Controllers\Donor;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use App\Models\Appointment;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonorDashboardController extends Controller
{
    private function getDonor()
    {
        return Donor::where('user_id', auth()->id())->first();
    }

    public function index()
    {
        $donor       = $this->getDonor();
        $appointment = $donor ? Appointment::where('donor_id', $donor->id)
            ->whereIn('status',['Pending','Confirmed'])
            ->orderBy('appointment_date')->first() : null;
        $donations   = $donor ? Donation::where('donor_id', $donor->id)
            ->orderByDesc('donation_date')->limit(5)->get() : collect();
        return view('donor.dashboard', compact('donor','appointment','donations'));
    }

    public function schedule()
    {
        $donor        = $this->getDonor();
        $appointments = $donor ? Appointment::where('donor_id', $donor->id)
            ->orderByDesc('appointment_date')->get() : collect();
        return view('donor.schedule', compact('donor','appointments'));
    }

    public function storeSchedule(Request $request)
    {
        $donor = $this->getDonor();
        if (!$donor) return back()->withErrors(['error' => 'No donor profile found.']);

        $request->validate([
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required',
            'location'         => 'required|string',
        ]);

        Appointment::create([
            'donor_id'         => $donor->id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'location'         => $request->location,
            'status'           => 'Pending',
        ]);

        return redirect()->route('donor.schedule')->with('success', 'Appointment scheduled successfully.');
    }

    public function cancelSchedule(Appointment $appointment)
    {
        if ($appointment->donor->user_id !== auth()->id()) abort(403);
        if ($appointment->status === 'Completed') {
            return back()->withErrors(['error' => 'Cannot cancel a completed appointment.']);
        }
        $appointment->update(['status' => 'Cancelled']);
        return redirect()->route('donor.schedule')->with('success', 'Appointment cancelled.');
    }

    public function history()
    {
        $donor     = $this->getDonor();
        $donations = $donor ? Donation::where('donor_id', $donor->id)
            ->orderByDesc('donation_date')->get() : collect();
        return view('donor.history', compact('donor','donations'));
    }

    public function profile()
    {
        $donor = $this->getDonor();
        return view('donor.profile', compact('donor'));
    }

    public function updateProfile(Request $request)
    {
        $donor = $this->getDonor();
        if (!$donor) return back()->withErrors(['error' => 'No donor profile found.']);

        $request->validate([
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'contact_number' => 'required|string|max:20',
            'address'        => 'required|string',
            'date_of_birth'  => 'required|date',
            'gender'         => 'required|in:Male,Female,Other',
        ]);

        $donor->update($request->only('first_name','last_name','contact_number','address','date_of_birth','gender'));
        auth()->user()->update(['name' => $request->first_name . ' ' . $request->last_name]);

        return redirect()->route('donor.profile')->with('success', 'Profile updated successfully.');
    }
}
