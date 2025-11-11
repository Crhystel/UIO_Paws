<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome'); 
})->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// --- Rutas Protegidas por Autenticación ---
Route::middleware('auth.user')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard para rol 'User'
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Dashboard para rol 'Admin'
    Route::middleware('is.admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    });

    // Dashboard para rol 'Super Admin'
    Route::middleware('is.superadmin')->prefix('superadmin')->name('superadmin.')->group(function () {
        Route::get('/users', [SuperAdminController::class, 'index'])->name('users.index');

    });
});