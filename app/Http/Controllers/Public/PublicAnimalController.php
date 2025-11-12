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

    /**
     * Muestra una galería pública de todos los animales disponibles.
     */
    public function index()
    {
        $response = Http::get("{$this->apiBaseUrl}/animals");

        if ($response->failed()) {
            return view('public.animals.index', ['animals' => [], 'paginator' => null])
                   ->with('error', 'No se pudieron cargar los animalitos en este momento.');
        }
        
        $apiResponse = $response->json();
        $animals = $apiResponse['data'] ?? [];
        $paginator = $apiResponse;
        return view('public.animals.index', compact('animals', 'paginator'));
    }

    /**
     * Muestra la información detallada de un solo animal.
     */
    public function show(string $id)
    {
        $response = Http::get("{$this->apiBaseUrl}/animals/{$id}");

        if ($response->failed()) {
            abort(404, 'Animal no encontrado.');
        }

        $animal = $response->json();
        return view('public.animals.show', compact('animal'));
    }
}