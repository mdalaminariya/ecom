<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class AuthenticationController extends Controller
{
    // Show login form
    public function login()
    {
        return view('auth.login');
    }

    // Show register form
    public function register()
    {
        return view('auth.register');
    }

    // Handle registration
    public function register_post(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Send verification email
        event(new Registered($user));

        return redirect()->route('verification.notice')
            ->with('success', 'Account created! Please check your email for verification.');
    }
}

