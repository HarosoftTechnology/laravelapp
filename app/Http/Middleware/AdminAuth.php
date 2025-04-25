<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // First, check whether the user is authenticated.
        if (!Auth::check()) {
            return redirect()->route('login')->with([
                'flash-message' => 'You must login!',
                'id'            => 'flash-message',
                'type'          => 'error',
                'position'      => 'bottom-right',
                'dismiss'       => false,
            ]);
        }

        // Retrieve the authenticated user.
        $user = Auth::user();

        // Now, check if the user has the required admin role.
        if (!in_array($user->role, ['admin', 'super-admin'])) {
            return redirect()->route('login')->with([
                'flash-message' => 'You do not have admin access!',
                'id'            => 'flash-message',
                'type'          => 'error',
                'position'      => 'bottom-right',
                'dismiss'       => false,
            ]);
        }

        return $next($request);
    }
}
