<?php
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PublicVolunteerController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL') . '/public';
    }

    public function index()
    {
        $response = Http::get("{$this->apiBaseUrl}/volunteer-opportunities");
        if ($response->failed()) {
            return view('public.volunteer.index', ['opportunities' => []])
                   ->with('error', 'No se pudieron cargar las oportunidades de voluntariado.');
        }
        $opportunities = $response->json();
        return view('public.volunteer.index', compact('opportunities'));
    }
}