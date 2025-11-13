<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class DonationItemsCatalogController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL') . '/admin';
    }

    private function getApiToken()
    {
        return Session::get('api_token');
    }

    /**
     * Muestra la lista de artículos para donación desde la API.
     */
    public function index()
    {
        $response = Http::withToken($this->getApiToken())->get("{$this->apiBaseUrl}/donation-items-catalog");

        if ($response->failed()) {
            return back()->with('error', 'No se pudieron cargar los artículos del catálogo.');
        }

        $items = $response->json();
        return view('admin.donation-items.index', compact('items'));
    }

    /**
     * Muestra el formulario para crear un nuevo artículo.
     */
    public function create()
    {
        return view('admin.donation-items.create');
    }

    /**
     * Guarda un nuevo artículo llamando a la API.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'item_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $response = Http::withToken($this->getApiToken())->post("{$this->apiBaseUrl}/donation-items-catalog", $validatedData);

        if ($response->failed()) {
            $errors = $response->json()['errors'] ?? ['api_error' => 'Error al crear el artículo. Revisa los datos.'];
            return back()->withErrors($errors)->withInput();
        }

        return redirect()->route('admin.donation-items.index')->with('success', 'Artículo creado exitosamente.');
    }

    /**
     * Muestra el formulario para editar un artículo.
     * El parámetro se llama $item porque lo definimos en la ruta.
     */
    public function edit(string $item)
    {
        $response = Http::withToken($this->getApiToken())->get("{$this->apiBaseUrl}/donation-items-catalog/{$item}");

        if ($response->failed()) {
            return redirect()->route('admin.donation-items.index')->with('error', 'Artículo no encontrado.');
        }

        $itemData = $response->json();
        return view('admin.donation-items.edit', ['item' => $itemData]);
    }

    /**
     * Actualiza un artículo llamando a la API.
     */
    public function update(Request $request, string $item)
    {
        $validatedData = $request->validate([
            'item_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $response = Http::withToken($this->getApiToken())->put("{$this->apiBaseUrl}/donation-items-catalog/{$item}", $validatedData);

        if ($response->failed()) {
            $errors = $response->json()['errors'] ?? ['api_error' => 'Error al actualizar el artículo.'];
            return back()->withErrors($errors)->withInput();
        }

        return redirect()->route('admin.donation-items.index')->with('success', 'Artículo actualizado exitosamente.');
    }

    /**
     * Elimina un artículo llamando a la API.
     */
    public function destroy(string $item)
    {
        $response = Http::withToken($this->getApiToken())->delete("{$this->apiBaseUrl}/donation-items-catalog/{$item}");

        if ($response->failed()) {
            return redirect()->route('admin.donation-items.index')->with('error', 'No se pudo eliminar el artículo.');
        }

        return redirect()->route('admin.donation-items.index')->with('success', 'Artículo eliminado exitosamente.');
    }
}