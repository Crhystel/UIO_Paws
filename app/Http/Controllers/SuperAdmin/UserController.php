<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL') . '/superadmin/users';
    }

    /**
     * Muestra la lista de todos los usuarios.
     */
    public function index()
    {
        $response = Http::withToken(Session::get('api_token'))->get($this->apiBaseUrl);

        if ($response->failed()) {
            return back()->with('error', 'No se pudieron cargar los usuarios. Inténtalo de nuevo.');
        }

        $users = $response->json();
        return view('superadmin.users.index', compact('users'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        return view('superadmin.users.create');
    }

    /**
     * Guarda un nuevo usuario llamando a la API.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:User,Admin,Super Admin',
        ]);

        $response = Http::withToken(Session::get('api_token'))->post($this->apiBaseUrl, $validated);

        if ($response->failed()) {
            return back()->withErrors($response->json('errors'))->withInput()->with('error', 'Error al crear el usuario.');
        }

        return redirect()->route('superadmin.users.index')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Muestra el formulario para editar un usuario existente.
     */
    public function edit(string $id)
    {
        $response = Http::withToken(Session::get('api_token'))->get($this->apiBaseUrl . '/' . $id);

        if ($response->failed()) {
            return redirect()->route('superadmin.users.index')->with('error', 'Usuario no encontrado.');
        }
        
        $user = $response->json();
        $user['role'] = $user['roles'][0]['name'] ?? 'User';

        return view('superadmin.users.edit', compact('user'));
    }

    /**
     * Actualiza un usuario existente llamando a la API.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'role' => 'required|string|in:User,Admin,Super Admin',
        ]);

        $response = Http::withToken(Session::get('api_token'))->put($this->apiBaseUrl . '/' . $id, $validated);

        if ($response->failed()) {
            return back()->withErrors($response->json('errors'))->withInput()->with('error', 'Error al actualizar el usuario.');
        }

        return redirect()->route('superadmin.users.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Elimina un usuario llamando a la API.
     */
    public function destroy(string $id)
    {
        $response = Http::withToken(Session::get('api_token'))->delete($this->apiBaseUrl . '/' . $id);

        if ($response->failed()) {
            return redirect()->route('superadmin.users.index')->with('error', 'No se pudo eliminar el usuario.');
        }
        
        return redirect()->route('superadmin.users.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}