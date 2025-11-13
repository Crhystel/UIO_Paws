<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class VolunteerOpportunityController extends Controller
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

    public function index()
    {
        $response = Http::withToken($this->getApiToken())->get("{$this->apiBaseUrl}/volunteer-opportunities");
        $opportunities = $response->json();
        return view('admin.volunteer-opportunities.index', compact('opportunities'));
    }

    public function create()
    {
        return view('admin.volunteer-opportunities.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
        ]);
        $validatedData['is_active'] = $request->has('is_active');

        $response = Http::withToken($this->getApiToken())->post("{$this->apiBaseUrl}/volunteer-opportunities", $validatedData);

        if ($response->failed()) {
            return back()->withErrors($response->json()['errors'] ?? ['api_error' => 'Error al crear la oportunidad.'])->withInput();
        }
        return redirect()->route('admin.volunteer-opportunities.index')->with('success', 'Oportunidad creada exitosamente.');
    }

    public function edit(string $opportunity)
    {
        $response = Http::withToken($this->getApiToken())->get("{$this->apiBaseUrl}/volunteer-opportunities/{$opportunity}");
        $opportunityData = $response->json();
        return view('admin.volunteer-opportunities.edit', ['opportunity' => $opportunityData]);
    }

    public function update(Request $request, string $opportunity)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
        ]);
        $validatedData['is_active'] = $request->has('is_active');

        $response = Http::withToken($this->getApiToken())->put("{$this->apiBaseUrl}/volunteer-opportunities/{$opportunity}", $validatedData);

        if ($response->failed()) {
            return back()->withErrors($response->json()['errors'] ?? ['api_error' => 'Error al actualizar la oportunidad.'])->withInput();
        }
        return redirect()->route('admin.volunteer-opportunities.index')->with('success', 'Oportunidad actualizada exitosamente.');
    }

    public function destroy(string $opportunity)
    {
        $response = Http::withToken($this->getApiToken())->delete("{$this->apiBaseUrl}/volunteer-opportunities/{$opportunity}");
        if ($response->failed()) {
            return redirect()->route('admin.volunteer-opportunities.index')->with('error', 'No se pudo eliminar la oportunidad.');
        }
        return redirect()->route('admin.volunteer-opportunities.index')->with('success', 'Oportunidad eliminada exitosamente.');
    }
}