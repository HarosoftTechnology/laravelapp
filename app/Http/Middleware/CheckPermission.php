<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $permission  The required permission alias.
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized.');
        }

        $user = Auth::user();

        // Check permission via the custom hasPermission function in the User model
        if (!$user->hasPermission($permission)) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
