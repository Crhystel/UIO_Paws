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
    public function index(Request $request)
    {
        $adopResponse = Http::withToken($this->getApiToken())
            ->get("{$this->apiBaseUrl}/adoption-applications", ['page' => $request->query('page_adop')]);
        $donResponse = Http::withToken($this->getApiToken())
            ->get("{$this->apiBaseUrl}/donation-applications", ['page' => $request->query('page_don')]);
        $volResponse = Http::withToken($this->getApiToken())
            ->get("{$this->apiBaseUrl}/volunteer-applications", ['page' => $request->query('page_vol')]);
        $adoptionsData = $adopResponse->successful() ? $adopResponse->json() : [];
        $donationsData = $donResponse->successful() ? $donResponse->json() : [];
        $volunteersData = $volResponse->successful() ? $volResponse->json() : [];

        return view('admin.applications.index', [
            'adoptions' => $adoptionsData['data'] ?? [],
            'adoptionsPaginator' => $adoptionsData,
            
            'donations' => $donationsData['data'] ?? [],
            'donationsPaginator' => $donationsData,
            
            'volunteers' => $volunteersData['data'] ?? [],
            'volunteersPaginator' => $volunteersData,
        ]);
    }
}