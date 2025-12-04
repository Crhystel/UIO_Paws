<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class DonationController extends Controller
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
     * Muestra el formulario de donación con la lista de artículos disponibles.
     */
    public function create(Request $request)
    {
        $response = Http::get("{$this->apiBaseUrl}/public/donation-items?per_page=100");

        if ($response->failed()) {
            return back()->with('error', 'No se pudo cargar la lista de artículos para donar.');
        }
        
        $responseJson = $response->json();
        $itemsCatalog = $responseJson['data'] ?? $responseJson;
        $preselectedId = $request->query('preselected_id');
        
        return view('user.donations.donation-form', compact('itemsCatalog', 'preselectedId'));
    }

    /**
     * Envía la solicitud de donación a la API.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer',
            'items.*.quantity' => 'required|integer|min:1',
        ]);
        $payloadItems = [];
        foreach ($validated['items'] as $item) {
            $payloadItems[] = [
                'id_donation_item_catalog' => $item['id'],
                'quantity' => $item['quantity'],
            ];
        }

        $response = Http::withToken($this->getApiToken())
            ->post("{$this->apiBaseUrl}/user/donation-applications", ['items' => $payloadItems]);

        if ($response->failed()) {
            $errors = $response->json()['errors'] ?? ['api_error' => 'Ocurrió un error al enviar tu solicitud. La API no respondió correctamente.'];
            return back()->withErrors($errors)->withInput();
        }
        
        return redirect()->route('adoption.my-applications')->with('success', '¡Tu ofrecimiento de donación ha sido enviado! Un administrador lo revisará pronto.');
    }
}