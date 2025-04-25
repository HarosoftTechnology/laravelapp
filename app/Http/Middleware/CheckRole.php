<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role  The required role alias
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            abort(403, 'Unauthorized.');
        }

        $user = Auth::user();

        // Check the role using the custom hasRole function
        if (!$user->hasRole($role)) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
