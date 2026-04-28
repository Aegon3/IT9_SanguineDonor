<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BloodInventory;
use Illuminate\Http\Request;

class BloodInventoryController extends Controller
{
    public function index()
    {
        $inventory = BloodInventory::orderBy('blood_type')->get();
        return view('admin.inventory.index', compact('inventory'));
    }

    public function edit(BloodInventory $inventory)
    {
        return view('admin.inventory.edit', compact('inventory'));
    }

    public function update(Request $request, BloodInventory $inventory)
    {
        $request->validate([
            'units_available' => 'required|integer|min:0',
            'capacity'        => 'required|integer|min:1',
            'expiry_date'     => 'nullable|date',
        ]);
        $inventory->update($request->only('units_available','capacity','expiry_date'));
        return redirect()->route('admin.inventory.index')->with('success', 'Inventory updated.');
    }
}
