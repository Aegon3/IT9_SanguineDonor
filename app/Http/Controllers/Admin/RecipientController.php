<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RecipientController extends Controller
{
    public function index()
    {
        $recipients = User::where('role', 'recipient')->orderByDesc('created_at')->get();
        return view('admin.recipients.index', compact('recipients'));
    }

    public function approve(User $user)
    {
        $user->update(['verification_status' => 'approved']);
        return back()->with('success', 'Recipient approved successfully.');
    }

    public function decline(User $user)
    {
        $user->update(['verification_status' => 'declined']);
        return back()->with('success', 'Recipient declined.');
    }
}
