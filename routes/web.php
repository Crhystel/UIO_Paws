<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\SuperAdmin\UserController as SuperAdminUserController;

Route::get('/', function() {
    return view('welcome'); 
})->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit')->middleware('guest');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit')->middleware('guest');


// --- Rutas Protegidas ---
Route::middleware('auth.user')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard para rol 'User'
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Rutas para Admins (y Super Admins)
    Route::middleware('is.admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    });
    
    // Rutas solo para Super Admins
    Route::middleware('is.superadmin')->prefix('superadmin')->name('superadmin.')->group(function () {
        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
        Route::resource('users', SuperAdminUserController::class);
    });
});