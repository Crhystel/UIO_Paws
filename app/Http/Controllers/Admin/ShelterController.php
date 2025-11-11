<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ShelterController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL') . '/admin/shelters';
    }

    /**
     * Muestra la lista de refugios.
     */
    public function index()
    {
        $response = Http::withToken(Session::get('api_token'))->get($this->apiBaseUrl);

        if ($response->failed()) {
            return back()->with('error', 'No se pudieron cargar los refugios.');
        }

        $shelters = $response->json();
        return view('admin.shelters.index', compact('shelters'));
    }

    /**
     * Muestra el formulario para crear un refugio.
     */
    public function create()
    {
        return view('admin.shelters.create');
    }

    /**
     * Guarda un nuevo refugio llamando a la API.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'shelter_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'description' => 'nullable|string',
            'address.street' => 'required|string|max:255',
            'address.city' => 'required|string|max:255',
            'address.province' => 'required|string|max:255',
            'address.postal_code' => 'required|string|max:20',
            'address.country' => 'required|string|max:255',
        ]);

        $response = Http::withToken(Session::get('api_token'))->post($this->apiBaseUrl, $validated);

        if ($response->failed()) {
            return back()->withErrors($response->json()['errors'])->withInput()->with('error', 'Error al crear el refugio.');
        }

        return redirect()->route('admin.shelters.index')->with('success', 'Refugio creado exitosamente.');
    }

    /**
     * Muestra el formulario para editar un refugio.
     */
    public function edit(string $id)
    {
        $response = Http::withToken(Session::get('api_token'))->get($this->apiBaseUrl . '/' . $id);

        if ($response->failed()) {
            return redirect()->route('admin.shelters.index')->with('error', 'Refugio no encontrado.');
        }
        
        $shelter = $response->json();
        return view('admin.shelters.edit', compact('shelter'));
    }

    /**
     * Actualiza un refugio existente.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'shelter_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'description' => 'nullable|string',
            'address.street' => 'required|string|max:255',
            'address.city' => 'required|string|max:255',
            'address.province' => 'required|string|max:255',
            'address.postal_code' => 'required|string|max:20',
            'address.country' => 'required|string|max:255',
        ]);

        $response = Http::withToken(Session::get('api_token'))->put($this->apiBaseUrl . '/' . $id, $validated);

        if ($response->failed()) {
            return back()->withErrors($response->json()['errors'])->withInput()->with('error', 'Error al actualizar el refugio.');
        }

        return redirect()->route('admin.shelters.index')->with('success', 'Refugio actualizado exitosamente.');
    }

    /**
     * Elimina un refugio.
     */
    public function destroy(string $id)
    {
        $response = Http::withToken(Session::get('api_token'))->delete($this->apiBaseUrl . '/' . $id);

        if ($response->failed()) {
            return redirect()->route('admin.shelters.index')->with('error', 'No se pudo eliminar el refugio.');
        }
        
        return redirect()->route('admin.shelters.index')->with('success', 'Refugio eliminado exitosamente.');
    }
}