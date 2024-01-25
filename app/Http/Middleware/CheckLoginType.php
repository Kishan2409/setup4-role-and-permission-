<?php

namespace App\Http\Middleware;

use App\Models\Client;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckLoginType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {

            // $user = auth()->user();
            // $client = Client::where('user_id', $user->added_by)->first();
            // // dd($user);
            // if ($client->login_type == 1) {
            //     Auth::logoutOtherDevices($user->password);
            //     return $next($request);
            // }
            return $next($request);
        }
        return response()->json(['message' => 'Unauthorized.'], 401);
    }
}
