<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;


class AuthServiceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated with the "auth_service" guard
        if (!Auth::guard('auth_service')->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
