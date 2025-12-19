<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AnimalController extends Controller
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
     * Muestra la lista de animales desde la API.
     */
    public function index()
    {
        $response = Http::withToken($this->getApiToken())->get("{$this->apiBaseUrl}/animals");

        if ($response->failed()) {
            return back()->with('error', 'No se pudieron cargar los animales desde la API.');
        }

        $apiResponse = $response->json();
        $animals = $apiResponse['data'] ?? [];
        $paginator = $apiResponse;

        return view('admin.animals.index', compact('animals', 'paginator'));
    }

    /**
     * Muestra el formulario para crear un animal, obteniendo antes las razas y refugios.
     */
    public function create()
    {
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
     * Guarda un nuevo animal y sus datos relacionados (foto, historial) llamando a la API.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'animal_name' => 'required|string|max:255',
            'status' => 'required|string',
            'birth_date' => 'nullable|date',
            'color' => 'required|string|max:50',
            'is_sterilized' => 'nullable|boolean',
            'description' => 'nullable|string',
            'id_breed' => 'required|integer',
            'id_shelter' => 'required|integer',
            'sex' => 'required|in:Macho,Hembra',
            'age' => 'required|integer|min:0',
            'size' => 'required|in:Pequeño,Mediano,Grande',
            'main_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'record_event_date' => 'nullable|date|required_with:record_event_type,record_description',
            'record_event_type' => 'nullable|string|max:255|required_with:record_event_date,record_description',
            'record_description' => 'nullable|string|required_with:record_event_date,record_event_type',
            'record_veterinarian_name' => 'nullable|string|max:255',
            'record_medicine_name' => 'nullable|string|max:255',
        ]);
        $animalData = $request->except([
            'main_photo', '_token',
            'record_event_date', 'record_event_type', 'record_description',
            'record_veterinarian_name', 'record_medicine_name'
        ]);
        $animalData['is_sterilized'] = $request->has('is_sterilized');
        
        $response = Http::withToken($this->getApiToken())->post("{$this->apiBaseUrl}/animals", $animalData);

        if ($response->failed()) {
            return back()->withErrors($response->json()['errors'] ?? ['api_error' => 'Error al crear el animal.'])->withInput();
        }
        
        $newAnimal = $response->json();
        $animalId = $newAnimal['id_animal'];

        if ($request->hasFile('main_photo')) {
        $photoResponse = Http::withToken($this->getApiToken())
            ->attach('photo', file_get_contents($request->file('main_photo')), $request->file('main_photo')->getClientOriginalName())
            ->post("{$this->apiBaseUrl}/animals/{$animalId}/photos");
        if ($photoResponse->failed()) {
            return back()->with('error', 'El animal se creó, pero la foto no pudo subirse. Por favor, edita el registro para añadirla.')->withInput();
        }
    }
    if ($request->filled(['record_event_date', 'record_event_type', 'record_description'])) {
        $medicalRecordData = [
            'event_date' => $request->input('record_event_date'),
            'event_type' => $request->input('record_event_type'),
            'description' => $request->input('record_description'),
            'veterinarian_name' => $request->input('record_veterinarian_name'),
            'medicine_name' => $request->input('record_medication'),
        ];
        $recordResponse = Http::withToken($this->getApiToken())->post("{$this->apiBaseUrl}/animals/{$animalId}/medical-records", $medicalRecordData);
        if ($recordResponse->failed()) {
            return back()->with('error', 'El animal se creó, pero su historial médico no pudo guardarse. Por favor, edita el registro para añadirlo.')->withInput();
        }
    }
    return redirect()->route('admin.animals.index')->with('success', 'Animal creado exitosamente con toda su información.');
}
    
    /**
     * Muestra el formulario para editar un animal.
     */
    public function edit(string $id)
    {
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
            'is_sterilized' => 'nullable|boolean',
            'description' => 'nullable|string',
            'id_breed' => 'required|integer',
            'id_shelter' => 'required|integer',
            'sex' => 'required|in:Macho,Hembra',
            'age' => 'required|integer|min:0',
            'size' => 'required|in:Pequeño,Mediano,Grande',
            'main_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
        $animalData = $request->except(['main_photo', '_token', '_method']);
        $animalData['is_sterilized'] = $request->has('is_sterilized');
        $response = Http::withToken($this->getApiToken())->put("{$this->apiBaseUrl}/animals/{$id}", $animalData);

        if ($response->failed()) {
            return back()->withErrors($response->json()['errors'] ?? ['api_error' => 'Error al actualizar el animal.'])->withInput();
        }
        if ($request->hasFile('main_photo')) {
            $animalDetailsResponse = Http::withToken($this->getApiToken())->get("{$this->apiBaseUrl}/animals/{$id}");
            $animalWithPhotos = $animalDetailsResponse->json();
            if (isset($animalWithPhotos['photos']) && !empty($animalWithPhotos['photos'])) {
                $photoId = $animalWithPhotos['photos'][0]['id_animal_photos'];
                Http::withToken($this->getApiToken())
                    ->attach('photo', file_get_contents($request->file('main_photo')), $request->file('main_photo')->getClientOriginalName())
                    ->post("{$this->apiBaseUrl}/photos/{$photoId}");
            } else {
                Http::withToken($this->getApiToken())
                    ->attach('photo', file_get_contents($request->file('main_photo')), $request->file('main_photo')->getClientOriginalName())
                    ->post("{$this->apiBaseUrl}/animals/{$id}/photos");
            }
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

    /**
     * Añade una nueva foto a la galería de un animal.
     */
    public function addPhoto(Request $request, string $id)
    {
        $request->validate(['photo' => 'required|image|max:2048']);
        
        $response = Http::withToken($this->getApiToken())
            ->attach('photo', file_get_contents($request->file('photo')), $request->file('photo')->getClientOriginalName())
            ->post("{$this->apiBaseUrl}/animals/{$id}/photos");

        if ($response->failed()) {
            return back()->with('error', 'No se pudo subir la foto.');
        }
        return back()->with('success', 'Foto añadida exitosamente.');
    }

    /**
     * Elimina una foto de la galería.
     */
    public function deletePhoto(string $photoId)
    {
        // La ruta a la API para eliminar una foto es independiente del animal
        $response = Http::withToken($this->getApiToken())->delete(env('API_BASE_URL') . "/admin/photos/{$photoId}");
        
        if ($response->failed()) {
            return back()->with('error', 'No se pudo eliminar la foto.');
        }
        return back()->with('success', 'Foto eliminada.');
    }

    /**
     * Añade un nuevo registro al historial médico.
     */
    public function addMedicalRecord(Request $request, string $id)
    {
        $validated = $request->validate([
            'event_date' => 'required|date',
            'event_type' => 'required|string',
            'description' => 'required|string',
            'veterinarian_name' => 'nullable|string|max:255',
            'medication' => 'nullable|string|max:255',
        ]);
        
        $response = Http::withToken($this->getApiToken())->post("{$this->apiBaseUrl}/animals/{$id}/medical-records", $validated);
        
        if ($response->failed()) {
            return back()->with('error', 'No se pudo añadir el registro.');
        }
        return back()->with('success', 'Registro médico añadido.');
    }

    /**
     * Elimina un registro del historial médico.
     */
    public function deleteMedicalRecord(string $recordId)
    {
        // La ruta a la API para eliminar un registro es independiente del animal
        $response = Http::withToken($this->getApiToken())->delete(env('API_BASE_URL') . "/admin/medical-records/{$recordId}");

        if ($response->failed()) {
            return back()->with('error', 'No se pudo eliminar el registro.');
        }
        return back()->with('success', 'Registro médico eliminado.');
    }
    /**
     * Actualiza un registro del historial médico.
     */
    public function updateMedicalRecord(Request $request, string $recordId)
    {
        $validated = $request->validate([
            'event_date' => 'required|date',
            'event_type' => 'required|string',
            'description' => 'required|string',
            'veterinarian_name' => 'nullable|string|max:255',
            'medication' => 'nullable|string|max:255',
        ]);

        $response = Http::withToken($this->getApiToken())
            ->put(env('API_BASE_URL') . "/admin/medical-records/{$recordId}", $validated);

        if ($response->failed()) {
            return back()->with('error', 'No se pudo actualizar el registro médico.');
        }

        return back()->with('success', 'Registro médico actualizado exitosamente.');
    }
}