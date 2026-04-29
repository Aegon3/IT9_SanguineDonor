<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function show()
    {
        if (Auth::check()) {
            return redirect()->route(Auth::user()->role . '.dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $rules = [
            'name'     => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|in:donor,recipient',
        ];

        if ($request->role === 'donor') {
            $rules['first_name']     = 'required|string|max:100';
            $rules['last_name']      = 'required|string|max:100';
            $rules['date_of_birth']  = 'required|date';
            $rules['gender']         = 'required|in:Male,Female,Other';
            $rules['contact_number'] = 'required|string|max:20';
            $rules['address']        = 'required|string';
            $rules['blood_type']     = 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-';
        }

        $request->validate($rules);

        $user = User::create([
            'name'                => $request->name,
            'username'            => $request->username,
            'email'               => $request->email,
            'password'            => Hash::make($request->password),
            'role'                => $request->role,
            'verification_status' => 'pending',
        ]);

        if ($request->role === 'donor') {
            Donor::create([
                'user_id'        => $user->id,
                'first_name'     => $request->first_name,
                'last_name'      => $request->last_name,
                'date_of_birth'  => $request->date_of_birth,
                'gender'         => $request->gender,
                'contact_number' => $request->contact_number,
                'email'          => $request->email,
                'address'        => $request->address,
                'blood_type'     => $request->blood_type,
                'status'         => 'Pending',
            ]);
        }

        Auth::login($user);
        return redirect()->route($user->role . '.dashboard');
    }
}