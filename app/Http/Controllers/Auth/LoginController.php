<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'role'     => 'required|in:admin,donor,recipient',
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role !== $request->role) {
                Auth::logout();
                return back()->withErrors(['username' => 'Account role does not match selected role.'])->withInput();
            }
            $request->session()->regenerate();
            return $this->redirectByRole($user->role);
        }

        return back()->withErrors(['username' => 'Invalid username or password.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    private function redirectByRole(string $role)
    {
        return match($role) {
            'admin'     => redirect()->route('admin.dashboard'),
            'donor'     => redirect()->route('donor.dashboard'),
            'recipient' => redirect()->route('recipient.dashboard'),
            default     => redirect()->route('login'),
        };
    }
}
