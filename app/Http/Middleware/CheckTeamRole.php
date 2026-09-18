<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckTeamRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // If the main merchant (Owner) is logged in, they have full access to everything.
        if (Auth::guard('merchant')->check()) {
            return $next($request);
        }

        // Check if a team member is logged in
        if (Auth::guard('team_member')->check()) {
            $user = Auth::guard('team_member')->user();

            if ($user->status !== 'active') {
                abort(403, 'Your account is not active.');
            }

            // The admin role has full access
            if ($user->role === 'admin') {
                return $next($request);
            }

            // If their role is in the allowed list, proceed
            if (in_array($user->role, $roles)) {
                return $next($request);
            }

            // Otherwise, block access
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized access.'], 403);
            }
            return redirect()->route('merchant.dashboard')->with('error', 'You do not have permission to access this section.');
        }

        return redirect()->route('merchant.login');
    }
}
