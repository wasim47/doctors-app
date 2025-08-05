<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    public function showLogin(Request $request)
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt login with email & password
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            
            // Check if user_type is 'Admin'
            if ($user && $user->user_type === 'Admin') {
                return redirect('/admin/dashboard');
            }

            // If not Admin, logout and deny access
            Auth::logout();
            return redirect('/')->with('error', 'Unauthorized access.');
        }

        return redirect('/')->with('error', 'Invalid credentials.');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
