<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthUserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('api_token')) {
            session(['url.intended' => $request->fullUrl()]);
            return redirect()->route('login');
        }

        return $next($request);
    }
}
