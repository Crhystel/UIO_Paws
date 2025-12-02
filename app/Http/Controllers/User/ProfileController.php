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
        $profileResponse = Http::withToken($this->getApiToken())->get("{$this->apiBaseUrl}/profile");
        $contactsResponse = Http::withToken($this->getApiToken())->get("{$this->apiBaseUrl}/user/emergency-contacts");

        if ($profileResponse->failed()) {
            return back()->with('error', 'No se pudo cargar tu perfil.');
        }

        $user = $profileResponse->json();
        $contacts = $contactsResponse->successful() ? $contactsResponse->json() : [];
        $apiUrl = $this->apiBaseUrl;
        return view('user.profile.show', compact('user', 'contacts','apiUrl'));
    }
    public function update(Request $request)
    {
        $payload = $request->except(['_token', '_method']);
        
        $response = Http::withToken($this->getApiToken())
            ->put("{$this->apiBaseUrl}/user/profile", $payload);

        if ($response->failed()) {
            return back()->withErrors($response->json('errors'))->withInput();
        }

        return redirect()->route('user.profile.show')->with('success', 'Perfil actualizado con éxito.');
    }
    public function updatePassword(Request $request)
    {
        $response = Http::withToken($this->getApiToken())
            ->put("{$this->apiBaseUrl}/user/profile/password", $request->all());

        if ($response->failed()) {
            return back()->withErrors($response->json('errors'))->withInput();
        }

        return redirect()->route('user.profile.show')->with('success', 'Contraseña actualizada.');
    }
    public function updatePhoto(Request $request)
    {
        $request->validate(['photo' => 'required|image|max:2048']);

        $response = Http::withToken($this->getApiToken())
            ->attach('photo', file_get_contents($request->file('photo')), $request->file('photo')->getClientOriginalName())
            ->post("{$this->apiBaseUrl}/user/profile/photo");
            
        if ($response->failed()) {
            return back()->with('error', 'No se pudo subir la foto.');
        }
        
        return redirect()->route('user.profile.show')->with('success', 'Foto de perfil actualizada.');
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