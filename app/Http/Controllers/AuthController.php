<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showSignupForm()
    {
        return view('signup');
    }

    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'position' => $request->position,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/signin');
    }

    public function showSigninForm()
    {
        return view('signin');
    }

    public function signin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect('/reports/create');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function showReportForm()
    {
        return view('report');
    }
}

