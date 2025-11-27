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
    public function index(Request $request)
    {
        $sheltersResponse = Http::get("{$this->apiBaseUrl}/shelters");
        $shelters = $sheltersResponse->successful() ? $sheltersResponse->json() : [];
        $queryParams = array_filter([
            'page'      => $request->query('page', 1),
            'category'  => $request->input('category'),
            'id_shelter'=> $request->input('id_shelter'),
            'search'    => $request->input('search'),
        ]);
        $response = Http::get("{$this->apiBaseUrl}/donation-items", $queryParams);
        
        if ($response->successful()) {
            $apiData = $response->json();
            $items = $apiData['data'] ?? []; 
            $paginator = $apiData; 
        } else {
            $items = [];
            $paginator = [];
        }

        return view('public.donations.index', compact('items', 'paginator', 'shelters'));
    }
}