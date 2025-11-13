<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\SuperAdmin\UserController as SuperAdminUserController;
use App\Http\Controllers\Public\PublicAnimalController;
use App\Http\Controllers\Admin\AnimalController;

Route::get('/', function() {
    return view('welcome'); 
})->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit')->middleware('guest');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit')->middleware('guest');

//Rutas publicas para ver animales
Route::get('/animales', [PublicAnimalController::class, 'index'])->name('public.animals.index');
Route::get('/animales/{id}', [PublicAnimalController::class, 'show'])->name('public.animals.show');


Route::middleware('auth.user')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard para rol 'User'
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Rutas para Admins (y Super Admins, ya que 'is.admin' debería incluirlos)
    Route::middleware('is.admin')->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // --- RECURSOS ---
    Route::resource('animals', \App\Http\Controllers\Admin\AnimalController::class);
    Route::resource('shelters', \App\Http\Controllers\Admin\ShelterController::class);
    Route::resource('species', \App\Http\Controllers\Admin\SpeciesController::class);
    Route::resource('breeds', \App\Http\Controllers\Admin\BreedController::class);
    // La URL será /admin/animals/{animal}/photos
    Route::post('animals/{animal}/photos', [AnimalController::class, 'addPhoto'])->name('animals.photos.store');
    // La URL será /admin/photos/{photo}
    Route::delete('photos/{photo}', [AnimalController::class, 'deletePhoto'])->name('photos.destroy');
    // La URL será /admin/animals/{animal}/records
    Route::post('animals/{animal}/records', [AnimalController::class, 'addMedicalRecord'])->name('animals.records.store');
    // La URL será /admin/records/{record}
    Route::put('records/{record}', [AnimalController::class, 'updateMedicalRecord'])->name('records.update');
    Route::delete('records/{record}', [AnimalController::class, 'deleteMedicalRecord'])->name('records.destroy');
});
    // Rutas solo para Super Admins
    Route::middleware('is.superadmin')->prefix('superadmin')->name('superadmin.')->group(function () {
        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
        Route::resource('users', SuperAdminUserController::class);
    });
});