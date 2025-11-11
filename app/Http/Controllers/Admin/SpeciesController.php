<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class SpeciesController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL') . '/admin/species';
    }

    public function index()
    {
        $response = Http::withToken(Session::get('api_token'))->get($this->apiBaseUrl);
        $species = $response->json();
        return view('admin.species.index', compact('species'));
    }

    public function create()
    {
        return view('admin.species.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['species_name' => 'required|string|max:255']);
        $response = Http::withToken(Session::get('api_token'))->post($this->apiBaseUrl, $validated);

        if ($response->failed()) {
            return back()->withErrors($response->json()['errors'] ?? ['api_error' => 'Error en la API'])->withInput();
        }
        return redirect()->route('admin.species.index')->with('success', 'Especie creada exitosamente.');
    }

    public function edit(string $id)
    {
        $response = Http::withToken(Session::get('api_token'))->get($this->apiBaseUrl . '/' . $id);
        $species = $response->json();
        return view('admin.species.edit', compact('species'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate(['species_name' => 'required|string|max:255']);
        $response = Http::withToken(Session::get('api_token'))->put($this->apiBaseUrl . '/' . $id, $validated);

        if ($response->failed()) {
            return back()->withErrors($response->json()['errors'] ?? ['api_error' => 'Error en la API'])->withInput();
        }
        return redirect()->route('admin.species.index')->with('success', 'Especie actualizada exitosamente.');
    }

    public function destroy(string $id)
    {
        Http::withToken(Session::get('api_token'))->delete($this->apiBaseUrl . '/' . $id);
        return redirect()->route('admin.species.index')->with('success', 'Especie eliminada exitosamente.');
    }
}