<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User; 
class SetAuthStatusFromSession
{
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('api_token') && !Auth::check()) {
            Auth::login(new User());
        }
        return $next($request);
    }
}