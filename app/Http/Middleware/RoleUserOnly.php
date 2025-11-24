<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class RoleUserOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): 
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userRole = Session::get('user_role');
        if ($userRole !== 'User') {
            if ($userRole === 'Admin') {
                return redirect()->route('admin.dashboard')->with('error', 'Los administradores no pueden realizar esta acción.');
            }
            if ($userRole === 'Super Admin') {
                return redirect()->route('superadmin.dashboard')->with('error', 'Los administradores no pueden realizar esta acción.');
            }
            return redirect('/')->with('error', 'No tienes permiso para realizar esta acción.');
        }
        return $next($request);
    }
}