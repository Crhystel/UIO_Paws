<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\SuperAdmin\UserController as SuperAdminUserController;
use App\Http\Controllers\Public\PublicAnimalController;
use App\Http\Controllers\Public\PublicDonationController;
use App\Http\Controllers\Public\PublicVolunteerController;
use App\Http\Controllers\User\AdoptionController;
use App\Http\Controllers\User\DonationController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Admin\Application\ApplicationController;

/*
RUTAS PÚBLICAS Y DE INVITADOS (NO AUTENTICADOS)
*/
Route::get('/', function() {
    return view('welcome');
})->name('home');

// Rutas públicas para visualizar contenido
Route::get('/animales', [PublicAnimalController::class, 'index'])->name('public.animals.index');
Route::get('/animales/{id}', [PublicAnimalController::class, 'show'])->name('public.animals.show');
Route::get('/donaciones', [PublicDonationController::class, 'index'])->name('public.donations.index');
Route::get('/voluntariado', [PublicVolunteerController::class, 'index'])->name('public.volunteer.index');

// Rutas para invitados (login, registro, etc.)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    Route::get('/iniciar-adopcion/{animal}', [AuthController::class, 'startAdoptionProcess'])->name('adoption.start');
});


/*
RUTAS PARA USUARIOS AUTENTICADOS
*/
Route::middleware('auth.user')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /*
    Rutas Exclusivas para el rol 'User'
    | Cualquier admin o superadmin que intente acceder será redirigido.
    */
    Route::middleware('role.user.only')->group(function () {
        // Dashboard principal del usuario
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Rutas para el proceso de adopción
        Route::prefix('adoptar')->name('adoption.')->group(function () {
            Route::get('/{animal}', [AdoptionController::class, 'showForm'])->name('form');
            Route::post('/{animal}', [AdoptionController::class, 'submitForm'])->name('submit');
        });

        // Rutas para el proceso de donación
        Route::prefix('donaciones-usuario')->name('user.donations.')->group(function () {
            Route::get('/ofrecer', [DonationController::class, 'create'])->name('create');
            Route::post('/ofrecer', [DonationController::class, 'store'])->name('store');
        });
        // Rutas para el proceso de voluntariado
        Route::prefix('voluntariado')->name('user.volunteer.')->group(function () {
            Route::get('/postular', [\App\Http\Controllers\User\VolunteerController::class, 'create'])->name('create');
            Route::post('/postular', [\App\Http\Controllers\User\VolunteerController::class, 'store'])->name('store');
        });
    });

    /*
    | Rutas Comunes para todos los roles autenticados (User, Admin, SuperAdmin)
    */
    // Ver mis solicitudes (un admin puede tener esta página, aunque esté vacía)
    Route::get('/mis-solicitudes', [AdoptionController::class, 'myApplications'])->name('adoption.my-applications');

    // Perfil de usuario (todos los roles tienen un perfil)
    Route::prefix('profile')->name('user.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('profile.show');
        Route::post('/emergency-contacts', [ProfileController::class, 'storeEmergencyContact'])->name('contacts.store');
        Route::delete('/emergency-contacts/{contact}', [ProfileController::class, 'destroyEmergencyContact'])->name('contacts.destroy');
    });
    /*
    Rutas para el rol 'Admin' (y por herencia, SuperAdmin)
    */
    Route::middleware('is.admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Recursos del Admin
        Route::resource('animals', \App\Http\Controllers\Admin\AnimalController::class);
        Route::resource('shelters', \App\Http\Controllers\Admin\ShelterController::class);
        Route::resource('species', \App\Http\Controllers\Admin\SpeciesController::class);
        Route::resource('breeds', \App\Http\Controllers\Admin\BreedController::class);
        Route::resource('donation-items', \App\Http\Controllers\Admin\DonationItemsCatalogController::class)->parameters(['donation-items' => 'item']);
        Route::resource('volunteer-opportunities', \App\Http\Controllers\Admin\VolunteerOpportunityController::class)->parameters(['volunteer-opportunities' => 'opportunity']);

        // Rutas anidadas para gestión de animales
        Route::post('animals/{animal}/photos', [\App\Http\Controllers\Admin\AnimalController::class, 'addPhoto'])->name('animals.photos.store');
        Route::delete('photos/{photo}', [\App\Http\Controllers\Admin\AnimalController::class, 'deletePhoto'])->name('photos.destroy');
        Route::post('animals/{animal}/records', [\App\Http\Controllers\Admin\AnimalController::class, 'addMedicalRecord'])->name('animals.records.store');
        Route::put('records/{record}', [\App\Http\Controllers\Admin\AnimalController::class, 'updateMedicalRecord'])->name('records.update');
        Route::delete('records/{record}', [\App\Http\Controllers\Admin\AnimalController::class, 'deleteMedicalRecord'])->name('records.destroy');
        //Ruta general para solicitudes
        Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
        // Rutas para revisar solicitudes de adopción
        Route::prefix('applications/adoption')->name('applications.adoption.')->group(function () {
            Route::get('/{application}', [\App\Http\Controllers\Admin\Adoption\AdoptionApplicationController::class, 'show'])->name('show');
            Route::put('/{application}/status', [\App\Http\Controllers\Admin\Adoption\AdoptionApplicationController::class, 'updateStatus'])->name('updateStatus'); // Cambiado a PUT
        });

        // Rutas para revisar solicitudes de donación
        Route::prefix('applications/donations')->name('applications.donation.')->group(function () {
            Route::get('/{application}', [\App\Http\Controllers\Admin\Donation\DonationApplicationController::class, 'show'])->name('show');
            Route::put('/{application}/status', [\App\Http\Controllers\Admin\Donation\DonationApplicationController::class, 'updateStatus'])->name('updateStatus');
        });
        //Rutas para ver todas las solicitudes
        Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
        // Rutas para revisar solicitudes de voluntariado
        Route::prefix('applications/volunteer')->name('applications.volunteer.')->group(function () {
            Route::get('/{application}', [\App\Http\Controllers\Admin\Volunteer\VolunteerApplicationController::class, 'show'])->name('show');
            Route::put('/{application}/status', [\App\Http\Controllers\Admin\Volunteer\VolunteerApplicationController::class, 'updateStatus'])->name('updateStatus');
        });
    });
    /*
     Rutas Exclusivas para el rol 'SuperAdmin'
    */
    Route::middleware('is.superadmin')->prefix('superadmin')->name('superadmin.')->group(function () {
        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
        Route::resource('users', SuperAdminUserController::class);
    });
});