<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function index()
    {
        $response = Http::withToken(Session::get('api_token'))
            ->get(env('API_BASE_URL') . '/admin/users');

        $users = $response->json();
        return view('admin.users', ['users' => $users]);
    }

    public function showEditForm($id)
    {
        $response = Http::withToken(Session::get('api_token'))
            ->get(env('API_BASE_URL') . "/admin/users/{$id}");
        return view('admin.edit-user', ['user' => $response->json()]);
    }

    public function update(Request $request, $id)
    {
        Http::withToken(Session::get('api_token'))
            ->put(env('API_BASE_URL') . "/admin/users/{$id}", $request->only('name', 'email', 'role'));
        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado.');
    }

    public function destroy($id)
    {
        Http::withToken(Session::get('api_token'))
            ->delete(env('API_BASE_URL') . "/admin/users/{$id}");
        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado.');
    }
}