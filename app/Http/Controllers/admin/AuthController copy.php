<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\BaseController;
use App\Models\Administration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Laravel\Passport\Passport;

class AuthController extends BaseController
{

    // Logout user
    public function showLogin(Request $request)
    {
        return view('admin.login');
    }

    // Login user
    /* public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Find user by email
        $user = Administration::where('email', $request->email)->first();
        

        // Check if user exists and status is active
        if (!$user || $user->status !== 1) {
            return response()->json([
                'message' => 'Unauthorized.',
                'errors' => ['error' => 'Invalid credentials or account is not active.'],
            ], 403);
        }

        // Validate password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Unauthorized.',
                'errors' => ['error' => 'Invalid credentials.'],
            ], 401);
        }
        $token = $user->createToken('Login Token')->accessToken;

        // Redirect to dashboard with success message
        return redirect()->route('dashboard')->with('success', 'Login successful!');
    } */


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Use the session-based 'administration' guard
        if (Auth::guard('administration')->attempt($request->only('email', 'password'))) {
            $user = Auth::guard('administration')->user();

            if ($user) {
                return redirect('/admin/dashboard');
            }

            Auth::guard('administration')->logout();
            return redirect('/')->with('error', 'Unauthorized access.');
        }

        return redirect('/')->with('error', 'Invalid credentials.');
    }

    public function logout(Request $request)
    {
        Auth::guard('administration')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
