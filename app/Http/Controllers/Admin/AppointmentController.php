<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Donor;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with('donor')->orderByDesc('appointment_date')->get();
        return view('admin.appointments.index', compact('appointments'));
    }

    public function create()
    {
        $donors = Donor::orderBy('first_name')->get();
        return view('admin.appointments.create', compact('donors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'donor_id'         => 'required|exists:donors,id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required',
            'location'         => 'required|string',
            'status'           => 'required|in:Pending,Confirmed,Completed,Cancelled',
        ]);

        Appointment::create([
            'donor_id'         => $request->donor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'location'         => $request->location,
            'status'           => $request->status,
        ]);

        return redirect()->route('admin.appointments.index')->with('success', 'Appointment created successfully.');
    }

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate(['status' => 'required|in:Pending,Confirmed,Completed,Cancelled']);
        $appointment->update(['status' => $request->status]);
        return back()->with('success', 'Appointment status updated.');
    }
}