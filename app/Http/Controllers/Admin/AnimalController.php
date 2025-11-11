<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AnimalController extends Controller
{
    private $apiBaseUrl;
    private $apiToken;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL') . '/admin';
    }
    private function getApiToken()
    {
        return Session::get('api_token');
    }

    /**
     * Muestra la lista de animales desde la API.
     */
    public function index()
    {
        $response = Http::withToken($this->getApiToken())->get("{$this->apiBaseUrl}/animals");

        if ($response->failed()) {
            return back()->with('error', 'No se pudieron cargar los animales desde la API.');
        }

        // La API devuelve un objeto paginado, necesitamos los datos y el paginador
        $apiResponse = $response->json();
        $animals = $apiResponse['data'];
        $paginator = $apiResponse; 

        return view('admin.animals.index', compact('animals', 'paginator'));
    }

    /**
     * Muestra el formulario para crear un animal, obteniendo antes las razas y refugios.
     */
    public function create()
    {
        // Hacemos dos peticiones a la API para poblar los <select> del formulario
        $breedsResponse = Http::withToken($this->getApiToken())->get("{$this->apiBaseUrl}/breeds");
        $sheltersResponse = Http::withToken($this->getApiToken())->get("{$this->apiBaseUrl}/shelters");

        if ($breedsResponse->failed() || $sheltersResponse->failed()) {
            return back()->with('error', 'No se pudieron cargar los datos para el formulario.');
        }

        $breeds = $breedsResponse->json();
        $shelters = $sheltersResponse->json();

        return view('admin.animals.create', compact('breeds', 'shelters'));
    }

    /**
     * Guarda un nuevo animal llamando a la API.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'animal_name' => 'required|string|max:255',
            'status' => 'required|string',
            'birth_date' => 'nullable|date',
            'color' => 'required|string|max:50',
            'is_sterilized' => 'nullable',
            'description' => 'nullable|string',
            'id_breed' => 'required|integer',
            'id_shelter' => 'required|integer',
            'sex' => 'required|in:Macho,Hembra',
            'age' => 'required|integer|min:0',
            'size' => 'required|in:Pequeño,Mediano,Grande',
        ]);
        
        $validatedData['is_sterilized'] = $request->has('is_sterilized');

        $response = Http::withToken($this->getApiToken())->post("{$this->apiBaseUrl}/animals", $validatedData);

        if ($response->status() >= 400) {
            return back()->withErrors($response->json()['errors'] ?? ['api_error' => 'Error al crear el animal en la API.'])->withInput();
        }

        return redirect()->route('admin.animals.index')->with('success', 'Animal creado exitosamente.');
    }

    /**
     * Muestra el formulario para editar un animal.
     */
    public function edit(string $id)
    {
        // Hacemos tres peticiones: una por el animal y dos por las dependencias del formulario
        $animalResponse = Http::withToken($this->getApiToken())->get("{$this->apiBaseUrl}/animals/{$id}");
        $breedsResponse = Http::withToken($this->getApiToken())->get("{$this->apiBaseUrl}/breeds");
        $sheltersResponse = Http::withToken($this->getApiToken())->get("{$this->apiBaseUrl}/shelters");

        if ($animalResponse->failed() || $breedsResponse->failed() || $sheltersResponse->failed()) {
            return redirect()->route('admin.animals.index')->with('error', 'No se pudieron cargar los datos para editar.');
        }

        $animal = $animalResponse->json();
        $breeds = $breedsResponse->json();
        $shelters = $sheltersResponse->json();
        
        return view('admin.animals.edit', compact('animal', 'breeds', 'shelters'));
    }

    /**
     * Actualiza un animal llamando a la API.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'animal_name' => 'required|string|max:255',
            'status' => 'required|string',
            'birth_date' => 'nullable|date',
            'color' => 'required|string|max:50',
            'is_sterilized' => 'nullable',
            'description' => 'nullable|string',
            'id_breed' => 'required|integer',
            'id_shelter' => 'required|integer',
            'sex' => 'required|in:Macho,Hembra',
            'age' => 'required|integer|min:0',
            'size' => 'required|in:Pequeño,Mediano,Grande',
        ]);

        $validatedData['is_sterilized'] = $request->has('is_sterilized');
        
        $response = Http::withToken($this->getApiToken())->put("{$this->apiBaseUrl}/animals/{$id}", $validatedData);

        if ($response->status() >= 400) {
            return back()->withErrors($response->json()['errors'] ?? ['api_error' => 'Error al actualizar el animal.'])->withInput();
        }

        return redirect()->route('admin.animals.index')->with('success', 'Animal actualizado exitosamente.');
    }

    /**
     * Elimina un animal llamando a la API.
     */
    public function destroy(string $id)
    {
        $response = Http::withToken($this->getApiToken())->delete("{$this->apiBaseUrl}/animals/{$id}");

        if ($response->failed()) {
            return redirect()->route('admin.animals.index')->with('error', 'No se pudo eliminar el animal.');
        }
        
        return redirect()->route('admin.animals.index')->with('success', 'Animal eliminado exitosamente.');
    }
}