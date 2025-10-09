<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;

// --- Rutas Públicas ---
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- Rutas Protegidas (Requieren estar logueado) ---
Route::middleware('auth.user')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- Rutas de Administrador ---
    Route::middleware('is.admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [AdminController::class, 'index'])->name('users.index');
        // Aquí irían las rutas para ver, editar y eliminar usuarios en el futuro
    });
});