<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserExpiry
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {

        if (Auth::check()) {
            $user = Auth::user();
            $today = now()->format('Y-m-d');

            if ($user->hasRole('superadmin') || $user->expiry_date >= $today || $user->expiry_date == null) {
                return $next($request);
            } else {
                Auth::logout();
                return redirect()->route('login')->withErrors(["mobile_no" => "Your plan is expired Please contact the admin."]);
            }
        }

        return $next($request);
    }
}
