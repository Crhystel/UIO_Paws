<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class VolunteerController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL');
    }

    private function getApiToken()
    {
        return Session::get('api_token');
    }

    /**
     * Muestra el formulario de postulación para una oportunidad específica.
     */
    public function create(Request $request)
    {
        $opportunityId = $request->query('opportunity_id');
        $opportunity = null;

        if ($opportunityId) {
            $response = Http::get("{$this->apiBaseUrl}/public/volunteer-opportunities");
            if ($response->successful()) {
                $opportunities = $response->json();
                $opportunity = collect($opportunities)->firstWhere('id_volunteer_opportunity', $opportunityId);
            }
        }

        return view('user.volunteer.volunteer-form', compact('opportunity'));
    }

    /**
     * Envía la solicitud a la API.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'motivation' => 'required|string|min:50|max:2000',
            'availability' => 'required|string',
            'experience' => 'required|string',   
            'terms_accepted' => 'required',
            'id_volunteer_opportunity' => 'nullable|integer'
        ]);
        $fullMotivation = "Motivación: " . $validated['motivation'] . 
                          "\n\nDisponibilidad: " . $validated['availability'] . 
                          "\n\nExperiencia: " . $validated['experience'];

        $payload = [
            'motivation' => $fullMotivation,
            'id_volunteer_opportunity' => $request->input('id_volunteer_opportunity'), 
        ];

        $response = Http::withToken($this->getApiToken())
            ->post("{$this->apiBaseUrl}/user/volunteer-applications", $payload);

        if ($response->failed()) {
            return back()->withErrors($response->json()['errors'] ?? ['api_error' => 'Error al enviar la solicitud.'])->withInput();
        }

        return redirect()->route('adoption.my-applications')->with('success', '¡Tu solicitud de voluntariado ha sido enviada!');
    }
}