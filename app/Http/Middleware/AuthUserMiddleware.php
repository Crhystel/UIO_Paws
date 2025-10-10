<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthUserMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Si no hay token o sesión, redirige al login
        if (!Session::has('api_token')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
