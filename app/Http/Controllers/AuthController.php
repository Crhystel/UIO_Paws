<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $response = Http::post(env('API_BASE_URL') . '/register', $validated);
        if ($response->successful()) {
            return redirect()->route('login')->with('success', '¡Registro exitoso! Por favor, inicia sesión.');
        }

        return back()->withErrors($response->json('errors'))->withInput();
    }

    public function login(Request $request)
{
    $validated = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $response = Http::post(env('API_BASE_URL') . '/login', $validated);

    if ($response->failed()) {
        return back()->withErrors(['email' => 'Las credenciales proporcionadas son incorrectas.'])->withInput();
    }

    $data = $response->json();

    // Validar que $data sea un array antes de acceder a offsets
    if (!is_array($data)) {
        return back()->withErrors(['email' => 'Error inesperado al iniciar sesión.'])->withInput();
    }

    $userRole = $data['user_role'] ?? 'user';

    Session::put('api_token', $data['access_token'] ?? null);
    Session::put('user_role', $userRole); 
    Session::put('user_name', $request->email);

    if ($userRole === 'admin') {
        return redirect()->route('admin.users.index');
    }

    return redirect()->route('dashboard');
}

    public function logout(Request $request)
    {
        Http::withToken(Session::get('api_token'))->post(env('API_BASE_URL') . '/logout');

        Session::flush();

        return redirect()->route('home');
    }
}