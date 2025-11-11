<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class IsAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $userRole = Session::get('user_role');
        if (!in_array($userRole, ['Admin', 'Super Admin'])) {
            return redirect()->route('dashboard')->with('error', 'No tienes permisos de Administrador.');
        }
        return $next($request);
    }
}