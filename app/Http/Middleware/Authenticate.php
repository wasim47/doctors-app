<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        // Default to checking 'web', 'administration', and 'api' guards if no specific guards are passed
        if (empty($guards)) {
            $guards = ['web', 'administration', 'api'];
        }

        // Loop through the guards to check if the user is authenticated with any of them
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return $next($request);
            }
        }

        // If the user is not authenticated, redirect them based on the type of route they are trying to access
        if ($request->is('admin/*') || $request->is('admin')) {
            // Redirect admin users to the admin login page
            return redirect()->route('admin.login');
        } elseif ($request->is('api/*')) {
            // For API requests, return a 401 Unauthorized response
            return response()->json(['error' => 'Unauthorized'], 401);
        } else {
            // Redirect regular users to the login page
            return redirect()->route('login');
        }
    }
}
