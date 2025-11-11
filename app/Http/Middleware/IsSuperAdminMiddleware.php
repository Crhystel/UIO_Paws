<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class IsSuperAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Session::get('user_role') !== 'Super Admin') {
            return redirect()->route('dashboard')->with('error', 'Acceso denegado. Se requieren privilegios de Super Administrador.');
        }
        return $next($request);
    }
}