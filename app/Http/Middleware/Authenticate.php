<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        // Check if the guard is specified
        if ($guard) {
            if (!Auth::guard($guard)->check()) {
                return redirect()->route('login')->withErrors(['You must be logged in to access this page.']);
            }
        } else {
            // If no guard is specified, check both guards
            if (!Auth::guard('web')->check() && !Auth::guard('company')->check()) {
                return redirect()->route('login')->withErrors(['You must be logged in to access this page.']);
            }
        }

        return $next($request);
    }
}
