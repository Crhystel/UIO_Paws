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
            return redirect()->route('login.form')->with('success', '¡Registro exitoso! Por favor, inicia sesión.');
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
        Session::put('api_token', $data['access_token']);
        Session::put('user_role', $data['user_role']);
        Session::put('user_name', $request->email); 
        if ($data['user_role'] === 'admin') {
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