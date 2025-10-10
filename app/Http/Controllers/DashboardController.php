<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Session::has('api_token')) {
            return redirect()->route('login');
        }
        return view('dashboard');
    }
}