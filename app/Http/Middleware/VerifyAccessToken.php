<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyAccessToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verify the access token
        if (Auth::guard('api')->check()) {
            return $next($request);
        }
        // Token is not valid, return unauthorized
        return response()->json([
            "error" => 0,
            "message" => "Unauthorized",
        ], 401);
    }
}
