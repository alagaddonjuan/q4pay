<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Ensure2FAIsVerified
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        $user = Auth::guard($guard)->user();

        if ($user && $user->two_factor_enabled) {
            // Check if 2FA session is validated
            if (!$request->session()->has('2fa_verified')) {
                $prefix = $guard === 'merchant' ? 'merchant.' : 'vendor.';
                
                // If the current route is the verification route or logout, allow it
                if ($request->routeIs($prefix . '2fa.verify') || $request->routeIs($prefix . '2fa.verify.post') || $request->routeIs('merchant.logout') || $request->routeIs('vendor.logout')) {
                    return $next($request);
                }
                
                // Otherwise, redirect to the 2FA verification page
                return redirect()->route($prefix . '2fa.verify');
            }
        }

        return $next($request);
    }
}
