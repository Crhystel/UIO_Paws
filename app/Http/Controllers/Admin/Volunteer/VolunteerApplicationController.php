<?php

namespace App\Http\Controllers\Admin\Volunteer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class VolunteerApplicationController extends Controller
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

    public function index(Request $request)
    {
        $queryParams = [
            'page' => $request->query('page', 1),
            'status' => $request->query('id_status'),
            'search' => $request->query('search'),
        ];

        $response = Http::withToken($this->getApiToken())->get("{$this->apiBaseUrl}/volunteer-applications", $queryParams);
        $statusesResponse = Http::withToken($this->getApiToken())->get("{$this->apiBaseUrl}/application-statuses");

        $applications = $response->successful() ? $response->json()['data'] : [];
        $paginator = $response->successful() ? $response->json() : [];
        $statuses = $statusesResponse->successful() ? $statusesResponse->json() : [];

        return view('admin.applications.volunteer.index', compact('applications', 'paginator', 'statuses'));
    }

    public function show(string $id)
    {
        $response = Http::withToken($this->getApiToken())->get("{$this->apiBaseUrl}/volunteer-applications/{$id}");
        $statusesResponse = Http::withToken($this->getApiToken())->get("{$this->apiBaseUrl}/application-statuses");

        if ($response->failed()) {
            return back()->with('error', 'No se pudo cargar la solicitud.');
        }

        $application = $response->json();
        $statuses = $statusesResponse->json();

        return view('admin.applications.volunteer.show', compact('application', 'statuses'));
    }

    public function updateStatus(Request $request, string $id)
    {
        $validated = $request->validate([
            'id_status' => 'required|integer',
            'admin_notes' => 'nullable|string',
        ]);

        $response = Http::withToken($this->getApiToken())
            ->put("{$this->apiBaseUrl}/volunteer-applications/{$id}/status", $validated);

        if ($response->failed()) {
            return back()->with('error', 'Error al actualizar estado.');
        }

        return redirect()->route('admin.applications.index')->with('success', 'Estado actualizado correctamente.');
    }
}