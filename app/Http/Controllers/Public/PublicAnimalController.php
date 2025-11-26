<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PublicAnimalController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL') . '/public';
    }

    public function index(Request $request)
    {
        $speciesResponse = Http::get("{$this->apiBaseUrl}/species");
        $breedsResponse = Http::get("{$this->apiBaseUrl}/breeds");
        $sheltersResponse = Http::get("{$this->apiBaseUrl}/shelters");

        $species = $speciesResponse->successful() ? $speciesResponse->json() : [];
        $breeds = $breedsResponse->successful() ? $breedsResponse->json() : [];
        $shelters = $sheltersResponse->successful() ? $sheltersResponse->json() : [];
        $queryParams = array_filter([
            'page'        => $request->query('page', 1),
            'animal_name' => $request->input('animal_name'),
            'id_species'  => $request->input('id_species'),
            'id_breed'    => $request->input('id_breed'),
            'id_shelter'  => $request->input('id_shelter'),
            'size'        => $request->input('size'),
            'color'       => $request->input('color'),
        ], fn($value) => !is_null($value) && $value !== '');
        $url = "{$this->apiBaseUrl}/animals";
        $response = Http::get($url, $queryParams);
        
        if ($response->successful()) {
            $apiData = $response->json();
            $animals = $apiData['data'] ?? []; 
            $paginator = $apiData; 
        } else {
            $animals = [];
            $paginator = [];
        }

        $apiUrl = env('API_URL'); 

        return view('public.animals.index', compact('animals', 'paginator', 'species', 'breeds', 'shelters', 'apiUrl'));
    }

    public function show(string $id)
    {
        $response = Http::get("{$this->apiBaseUrl}/animals/{$id}");

        if ($response->failed()) {
            abort(404, 'Animal no encontrado.');
        }

        $animal = $response->json();
        $apiUrl = env('API_URL'); 
        
        return view('public.animals.show', compact('animal', 'apiUrl'));
    }
}