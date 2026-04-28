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

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate(['status' => 'required|in:Pending,Confirmed,Completed,Cancelled']);
        $appointment->update(['status' => $request->status]);
        return back()->with('success', 'Appointment status updated.');
    }
}
