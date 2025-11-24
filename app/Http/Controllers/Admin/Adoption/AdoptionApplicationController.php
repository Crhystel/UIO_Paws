<?php

namespace App\Http\Controllers\Admin\Adoption;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AdoptionApplicationController extends Controller
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
     * Muestra una lista de todas las solicitudes de adopción.
     */
    public function index()
    {
        $response = Http::withToken($this->getApiToken())->get("{$this->apiBaseUrl}/adoption-applications");

        if ($response->failed()) {
            return back()->with('error', 'No se pudieron cargar las solicitudes de adopción.');
        }
        
        $apiResponse = $response->json();
        $applications = $apiResponse['data'] ?? [];
        $paginator = $apiResponse;

        return view('admin.applications.adoption.index', compact('applications', 'paginator'));
    }

    /**
     * Muestra los detalles completos de una solicitud específica.
     */
    public function show(string $applicationId)
    {
        $applicationResponse = Http::withToken($this->getApiToken())->get("{$this->apiBaseUrl}/adoption-applications/{$applicationId}");
        $statusesResponse = Http::withToken($this->getApiToken())->get("{$this->apiBaseUrl}/application-statuses");

        if ($applicationResponse->failed() || $statusesResponse->failed()) {
            return redirect()->route('admin.applications.adoption.index')->with('error', 'No se pudieron cargar los detalles de la solicitud.');
        }

        $application = $applicationResponse->json();
        $statuses = $statusesResponse->json();

        return view('admin.applications.adoption.show', compact('application', 'statuses'));
    }

    /**
     * Actualiza el estado de una solicitud.
     */
    public function updateStatus(Request $request, string $applicationId)
    {
        $validated = $request->validate([
            'id_status' => 'required|integer',
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        $response = Http::withToken($this->getApiToken())
            ->put("{$this->apiBaseUrl}/adoption-applications/{$applicationId}/status", $validated);

        if ($response->failed()) {
            return back()->with('error', 'No se pudo actualizar el estado de la solicitud.')->withInput();
        }

        return redirect()->route('admin.applications.adoption.index')->with('success', 'El estado de la solicitud ha sido actualizado exitosamente.');
    }
}