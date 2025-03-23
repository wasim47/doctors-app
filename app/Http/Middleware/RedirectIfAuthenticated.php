<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        // If no specific guards are passed, check both 'web' and 'administration' guards
        if (empty($guards)) {
            $guards = ['web', 'administration'];
        }

        // Loop through each guard and check if the user is authenticated
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Redirect to the appropriate dashboard based on the guard
                if ($guard === 'administration') {
                    return redirect()->route('admin.dashboard');  // Redirect to admin dashboard
                } elseif ($guard === 'web') {
                    return redirect()->route('user.dashboard');  // Redirect to user dashboard
                }
            }
        }

        // If no user is authenticated, proceed with the request
        return $next($request);
    }
}
