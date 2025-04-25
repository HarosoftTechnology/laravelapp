<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionTimeout
{
    // Timeout period in seconds (15 minutes)
    protected $timeout = 900;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $lastActivity = session('lastActivityTime');
            if ($lastActivity && (time() - $lastActivity > $this->timeout)) {
                // Save current URL to resume column of the user
                $user = Auth::user();
                $user->resume = $request->fullUrl();
                $user->save();

                // Logout user, invalidate session, and regenerate token
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->to(url_to_pager('login'))->with([
                    'flash-message'   => "Session timeout! Login again.",
                    'flash-type'      => 'error',
                    'flash-dismiss'   => true,
                    'flash-position'  => 'bottom-right',
                ]);
            }

            // Update the last activity time
            session(['lastActivityTime' => time()]);
        }

        return $next($request);
    }
}
