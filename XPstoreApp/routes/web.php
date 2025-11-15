<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\VideoGameController;
use App\Http\Controllers\Admin\GameCodeController;


// =========================
// PÁGINA PRINCIPAL (HOME)
// =========================
Route::get('/', function () {

    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return app(HomeController::class)->index();
})->name('home');


// =========================
// AUTENTICACIÓN (solo invitados)
// =========================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});


// =========================
// ÁREA PRIVADA (solo logueados)
// =========================
Route::middleware('auth')->group(function () {

    // Redirección automática según rol
    Route::get('/dashboard', function () {
        $user = Auth::user();

        return $user->role === 'admin'
            ? redirect()->route('dashboard.admin')
            : redirect()->route('dashboard.user');
    })->name('dashboard');

    // Dashboard ADMIN
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])
        ->name('dashboard.admin');

    // Dashboard USER
    Route::get('/dashboard/user', [DashboardController::class, 'user'])
        ->name('dashboard.user');

    // =========================
    // CRUD ADMIN - VIDEOJUEGOS 
    // =========================
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('videojuegos', VideoGameController::class);
        Route::resource('gamecodes', GameCodeController::class);
    });


    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});
