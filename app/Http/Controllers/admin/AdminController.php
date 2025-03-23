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

class AdminController extends BaseController
{

    public function __construct()
    {
        //$this->middleware('auth:administration');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // Logout user
    /* public function logout()
    {
        Auth::guard('administration')->logout();
        return redirect()->route('admin.login'); // Redirect to login page
    } */

    
}
