<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use Illuminate\Http\Request;

class DonorController extends Controller
{
    public function index()
    {
        $donors = Donor::orderByDesc('created_at')->get();
        return view('admin.donors.index', compact('donors'));
    }

    public function create()
    {
        return view('admin.donors.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'date_of_birth'  => 'required|date',
            'gender'         => 'required|in:Male,Female,Other',
            'contact_number' => 'required|string|max:20',
            'email'          => 'nullable|email',
            'address'        => 'required|string',
            'blood_type'     => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'status'         => 'required|in:Active,Pending,Inactive',
        ]);

        Donor::create($data);
        return redirect()->route('admin.donors.index')->with('success', 'Donor registered successfully.');
    }

    public function edit(Donor $donor)
    {
        return view('admin.donors.edit', compact('donor'));
    }

    public function update(Request $request, Donor $donor)
    {
        $data = $request->validate([
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'date_of_birth'  => 'required|date',
            'gender'         => 'required|in:Male,Female,Other',
            'contact_number' => 'required|string|max:20',
            'email'          => 'nullable|email',
            'address'        => 'required|string',
            'blood_type'     => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'status'         => 'required|in:Active,Pending,Inactive',
        ]);
        $donor->update($data);
        return redirect()->route('admin.donors.index')->with('success', 'Donor updated.');
    }

    public function destroy(Donor $donor)
    {
        $donor->delete();
        return redirect()->route('admin.donors.index')->with('success', 'Donor removed.');
    }
}
