<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
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
     * Muestra la página de perfil del usuario, incluyendo sus contactos.
     */
    public function show()
    {
        $response = Http::withToken($this->getApiToken())->get("{$this->apiBaseUrl}/user/emergency-contacts");

        if ($response->failed()) {
            return redirect()->route('dashboard')->with('error', 'No se pudo cargar la información de tu perfil.');
        }

        $contacts = $response->json();
        return view('user.profile', compact('contacts'));
    }

    /**
     * Envía los datos de un nuevo contacto a la API para guardarlo.
     */
    public function storeEmergencyContact(Request $request)
    {
        $validated = $request->validate([
            'contact_name' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'relationship' => 'required|string|max:100',
        ]);
        $response = Http::withToken($this->getApiToken())->post("{$this->apiBaseUrl}/user/emergency-contacts", $validated);

        if ($response->failed()) {
            return back()->with('error', 'No se pudo guardar el contacto. Inténtalo de nuevo.');
        }

        return redirect()->route('user.profile.show')->with('success', '¡Contacto de emergencia añadido con éxito!');
    }

    /**
     * Pide a la API que elimine un contacto.
     */
    public function destroyEmergencyContact(string $contactId)
    {
        $response = Http::withToken($this->getApiToken())->delete("{$this->apiBaseUrl}/user/emergency-contacts/{$contactId}");

        if ($response->failed()) {
            return back()->with('error', 'No se pudo eliminar el contacto.');
        }

        return redirect()->route('user.profile.show')->with('success', 'Contacto eliminado.');
    }
}