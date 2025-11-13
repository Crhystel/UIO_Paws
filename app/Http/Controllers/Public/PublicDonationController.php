<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PublicDonationController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL') . '/public';
    }

    /**
     * Muestra la lista pública de artículos necesarios para donar.
     */
    public function index()
    {
        $response = Http::get("{$this->apiBaseUrl}/donation-items");
        if ($response->failed()) {
            return view('public.donations.index', ['items' => []])
                   ->with('error', 'No pudimos cargar la lista de artículos necesarios en este momento.');
        }
        
        $items = $response->json();
        
        return view('public.donations.index', compact('items'));
    }
}