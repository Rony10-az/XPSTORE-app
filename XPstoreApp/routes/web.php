<?php

use App\Http\Controllers\Homecontroller;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\AuthController;

// Auth routes (demo in-memory)
// Mostrar formulario de login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
// Mostrar formulario de registro
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
// Cerrar sesión
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// comentario
Route::get('/dashboard', function () {
    // Ruta protegida: verifica sesión manualmente (demo)
    if (!session()->has('user')) {
        return redirect()->route('login');
    }
    return view('dashboard');
})->name('dashboard');
