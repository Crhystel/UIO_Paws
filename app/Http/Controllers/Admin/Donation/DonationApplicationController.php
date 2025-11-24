<?php

namespace App\Http\Controllers\Admin\Donation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class DonationApplicationController extends Controller
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
        $response = Http::withToken($this->getApiToken())->get("{$this->apiBaseUrl}/donation-applications");
        if ($response->failed()) {
            return back()->with('error', 'No se pudieron cargar las solicitudes de donación.');
        }
        $apiResponse = $response->json();
        $applications = $apiResponse['data'] ?? [];
        $paginator = $apiResponse;

        return view('admin.applications.donation.index', compact('applications', 'paginator'));
    }

    public function show(string $applicationId)
    {
        $appResponse = Http::withToken($this->getApiToken())->get("{$this->apiBaseUrl}/donation-applications/{$applicationId}");
        $statusesResponse = Http::withToken($this->getApiToken())->get("{$this->apiBaseUrl}/application-statuses");

        if ($appResponse->failed() || $statusesResponse->failed()) {
            return redirect()->route('admin.applications.donation.index')->with('error', 'No se pudo cargar la solicitud.');
        }
        $application = $appResponse->json();
        $statuses = $statusesResponse->json();

        return view('admin.applications.donation.show', compact('application', 'statuses'));
    }

    public function updateStatus(Request $request, string $applicationId)
    {
        $validated = $request->validate([
            'id_status' => 'required|integer',
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        $response = Http::withToken($this->getApiToken())
            ->put("{$this->apiBaseUrl}/donation-applications/{$applicationId}/status", $validated);

        if ($response->failed()) {
            return back()->with('error', 'No se pudo actualizar el estado de la solicitud.')->withInput();
        }
        
        return redirect()->route('admin.applications.donation.index')->with('success', 'Estado actualizado.');
    }
}