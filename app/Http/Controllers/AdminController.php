<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    private function checkAdminAccess()
    {
        if (!Session::has('api_token')) {
            return redirect()->route('login');
        }
        if (Session::get('user_role') !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Acceso denegado.');
        }
        return null; 
    }
    public function index()
    {
        if ($redirect = $this->checkAdminAccess()) return $redirect; 

        $response = Http::withToken(Session::get('api_token'))->get(env('API_BASE_URL') . '/admin/users');
        return view('admin.users', ['users' => $response->json()]);
    }

    public function showEditForm($id)
    {
        if ($redirect = $this->checkAdminAccess()) return $redirect; 

        $response = Http::withToken(Session::get('api_token'))->get(env('API_BASE_URL') . "/admin/users/{$id}");
        return view('admin.edit-user', ['user' => $response->json()]);
    }

    public function update(Request $request, $id)
    {
        if ($redirect = $this->checkAdminAccess()) return $redirect; 

        Http::withToken(Session::get('api_token'))->put(env('API_BASE_URL') . "/admin/users/{$id}", $request->only('name', 'email', 'role'));
        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado.');
    }

    public function destroy($id)
    {
        if ($redirect = $this->checkAdminAccess()) return $redirect; 

        Http::withToken(Session::get('api_token'))->delete(env('API_BASE_URL') . "/admin/users/{$id}");
        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado.');
    }
}