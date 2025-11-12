<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class PublicAnimalController extends Controller
{
    public function show(string $id)
    {
        $apiBaseUrl = env('API_BASE_URL') . '/public';
        $response = Http::get("{$apiBaseUrl}/animals/{$id}");

        if ($response->failed()) {
            abort(404, 'Animal no encontrado.');
        }

        $animal = $response->json();
        return view('public.animals.show', compact('animal'));
    }
}