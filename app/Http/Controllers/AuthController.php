<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

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
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255', 
            'last_name' => 'required|string|max:255',
            'second_last_name' => 'nullable|string|max:255', 
            'document_type' => 'required|string|max:255',
            'document_number' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
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
            throw ValidationException::withMessages([
                'email' => 'Las credenciales proporcionadas son incorrectas.',
            ]);
        }

        $data = $response->json();
        Session::put('api_token', $data['access_token']);
        Session::put('user_role', $data['user_role']);
        $profileResponse = Http::withToken($data['access_token'])->get(env('API_BASE_URL') . '/profile');
        if($profileResponse->successful()){
            $userProfile = $profileResponse->json();
            Session::put('user_name', $userProfile['first_name']);
        } else {
             Session::put('user_name', 'Usuario');
        }


        switch ($data['user_role']) {
            case 'Super Admin':
                return redirect()->intended(route('superadmin.dashboard'));
            case 'Admin':
                return redirect()->intended(route('admin.dashboard'));
            default: 
                return redirect()->intended(route('dashboard'));
        }
    }

    public function logout(Request $request)
    {
        Http::withToken(Session::get('api_token'))->post(env('API_BASE_URL') . '/logout');
        
        Session::flush();
        
        return redirect()->route('home');
    }
}