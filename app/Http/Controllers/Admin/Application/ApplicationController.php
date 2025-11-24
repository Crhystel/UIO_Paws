<?php

namespace App\Http\Controllers\Admin\Application;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ApplicationController extends Controller
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
     * Muestra la vista unificada de todas las solicitudes.
     */
    public function index()
    {
        $response = Http::withToken($this->getApiToken())->get("{$this->apiBaseUrl}/applications-summary");

        if ($response->failed()) {
            return back()->with('error', 'No se pudieron cargar las solicitudes desde la API.');
        }
        
        $data = $response->json();
        
        return view('admin.applications.index', [
            'adoptions' => $data['adoptions']['data'] ?? [],
            'donations' => $data['donations']['data'] ?? [],
            'adoptionsPaginator' => $data['adoptions'],
            'donationsPaginator' => $data['donations']
        ]);
    }
}