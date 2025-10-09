<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function index()
    {
        $response = Http::withToken(Session::get('api_token'))
            ->get(env('API_BASE_URL') . '/admin/users');

        if ($response->failed()) {
            return redirect()->route('login.form')->withErrors(['email' => 'Tu sesión ha expirado.']);
        }

        $users = $response->json();
        return view('admin.users', ['users' => $users]);
    }
}