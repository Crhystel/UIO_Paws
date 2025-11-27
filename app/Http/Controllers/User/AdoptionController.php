<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AdoptionController extends Controller
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
     * Muestra el formulario de adopción.
     */
    public function showForm(string $animalId)
    {
        $response = Http::get("{$this->apiBaseUrl}/public/animals/{$animalId}");

        if ($response->failed() || $response->json()['status'] !== 'Disponible') {
            return redirect()->route('public.animals.index')->with('error', 'Este animalito ya no está disponible para adopción.');
        }

        $animal = $response->json();
        return view('user.adoption.adoption-form', compact('animal'));
    }

    /**
     * Envía la solicitud de adopción a la API.
     */
    public function submitForm(Request $request, string $animalId)
    {
        $validated = $request->validate([
            'home_info.dwelling_type' => 'required|string|max:255',
            'home_info.has_yard' => 'required|boolean',
            'home_info.yard_enclosure_type' => 'nullable|string|max:255',
            'home_info.wall_material' => 'required|string|max:255',
            'home_info.floor_material' => 'required|string|max:255',
            'home_info.room_count' => 'required|integer|min:1',
            'home_info.bathroom_count' => 'required|integer|min:1',
            'home_info.adults_in_home' => 'required|integer|min:1',
            'home_info.has_balcony' => 'required|boolean',
            'home_info.current_pet_count' => 'required|integer|min:0',
            'home_info.others_pets_description' => 'nullable|string',
            'home_info.all_members_agree' => 'required|boolean',
            'home_info.previous_pets_history' => 'nullable|string',
            'home_info.motivation_for_adoption' => 'required|string|min:20',
            'home_info.hours_pet_will_be_alone' => 'required|integer|min:0|max:24',
            'home_info.location_when_alone' => 'required|string',
            'home_info.exercise_plan' => 'required|string',
            'home_info.vacation_emergency_plan' => 'required|string',
            'home_info.behavioral_issue_plan' => 'required|string',
            'home_info.vet_reference_name' => 'nullable|string|max:255',
            'home_info.vet_reference_phone' => 'nullable|string|max:20',
            'terms_accepted' => 'required',
        ]);
        $payload = [
            'id_animal' => $animalId,
            'home_info' => $validated['home_info'],
            'terms_accepted' => $request->has('terms_accepted') 
        ];
        $response = Http::withToken($this->getApiToken())
            ->post("{$this->apiBaseUrl}/user/adoption-applications", $payload);
        if ($response->failed()) {
            return back()->withErrors($response->json()['errors'] ?? ['api_error' => 'Ocurrió un error al enviar tu solicitud.'])->withInput();
        }
        return redirect()->route('adoption.my-applications')->with('success', $response->json()['message']);
    }

    /**
     * Muestra todas las solicitudes del usuario.
     */
    public function myApplications()
    {
        $response = Http::withToken($this->getApiToken())->get("{$this->apiBaseUrl}/user/my-applications");
        if ($response->failed()) {
            return redirect()->route('dashboard')->with('error', 'No se pudieron cargar tus solicitudes.');
        }
        $data = $response->json(); 
        $apiUrl = env('API_URL'); 
        return view('user.my-applications', array_merge($data, [
            'applications' => $data, 
            'apiUrl' => $apiUrl
        ]));
    }
}