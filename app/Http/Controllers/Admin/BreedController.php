<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class BreedController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL') . '/admin';
    }

    private function getSpecies()
    {
        $response = Http::withToken(Session::get('api_token'))->get("{$this->apiBaseUrl}/species");
        return $response->json();
    }

    public function index()
    {
        $response = Http::withToken(Session::get('api_token'))->get("{$this->apiBaseUrl}/breeds");
        $breeds = $response->json();
        return view('admin.breeds.index', compact('breeds'));
    }

    public function create()
    {
        $species = $this->getSpecies();
        return view('admin.breeds.create', compact('species'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'breed_name' => 'required|string|max:255',
            'id_species' => 'required|integer',
        ]);
        $response = Http::withToken(Session::get('api_token'))->post("{$this->apiBaseUrl}/breeds", $validated);

        if ($response->failed()) {
            return back()->withErrors($response->json()['errors'] ?? ['api_error' => 'Error en la API'])->withInput();
        }
        return redirect()->route('admin.breeds.index')->with('success', 'Raza creada exitosamente.');
    }

    public function edit(string $id)
    {
        $breedResponse = Http::withToken(Session::get('api_token'))->get("{$this->apiBaseUrl}/breeds/{$id}");
        $breed = $breedResponse->json();
        $species = $this->getSpecies();
        return view('admin.breeds.edit', compact('breed', 'species'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'breed_name' => 'required|string|max:255',
            'id_species' => 'required|integer',
        ]);
        $response = Http::withToken(Session::get('api_token'))->put("{$this->apiBaseUrl}/breeds/{$id}", $validated);

        if ($response->failed()) {
            return back()->withErrors($response->json()['errors'] ?? ['api_error' => 'Error en la API'])->withInput();
        }
        return redirect()->route('admin.breeds.index')->with('success', 'Raza actualizada exitosamente.');
    }

    public function destroy(string $id)
    {
        Http::withToken(Session::get('api_token'))->delete("{$this->apiBaseUrl}/breeds/{$id}");
        return redirect()->route('admin.breeds.index')->with('success', 'Raza eliminada exitosamente.');
    }
}