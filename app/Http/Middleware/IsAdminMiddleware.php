<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $userRole = Session::get('user_role');
        if ($userRole !== 'Admin' && $userRole !== 'Super Admin') {
            return redirect()->route('dashboard')->with('error', 'No tienes permisos para acceder a esta sección.');
        }
        return $next($request);
    }
}
