<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GameCodeController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\VideoGameController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Store\GameStoreController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// PÁGINA PRINCIPAL (HOME)
// =========================
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return app(HomeController::class)->index();
})->name('home');

// =========================
// TIENDA (pública)
// =========================
Route::get('/juegos', [GameStoreController::class, 'index'])->name('store.index');
Route::get('/juego/{videojuego}', [GameStoreController::class, 'show'])->name('game.show');

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
    Route::get('/dashboard', function () {
        $user = Auth::user();
        return $user->role === 'admin'
            ? redirect()->route('dashboard.admin')
            : redirect()->route('dashboard.user');
    })->name('dashboard');

    // ADMIN
    Route::get('/dashboard/admin', [AdminDashboardController::class, 'index'])->name('dashboard.admin');

    // CRUD de Videojuegos (solo admins)
    Route::resource('videojuegos', VideoGameController::class)->names('videojuegos');

    // Rutas de administración (solo admins)
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('videojuegos', VideoGameController::class);
        Route::resource('users', AdminUserController::class)->except(['create', 'store']);
        Route::resource('gamecodes', GameCodeController::class);
        Route::resource('reviews', ReviewController::class)->only(['index', 'destroy']);
        Route::resource('items', ItemController::class)->only(['index']);
        Route::get('settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings');
        Route::post('settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
    });

    /* dados de prueba para ver si se sube bien el cambio */
    // USER
    Route::get('/dashboard/user', [UserDashboardController::class, 'index'])->name('dashboard.user');

    // PERFIL
    Route::get('/perfil', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/perfil/update', [ProfileController::class, 'update'])->name('profile.update');

    // Carrito
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // STORE ACTIONS
    Route::post('/carrito/{videojuego}', [GameStoreController::class, 'addToCart'])->name('store.cart.add');
    Route::post('/favorito/{videojuego}', [GameStoreController::class, 'toggleWishlist'])->name('store.wishlist.toggle');
    Route::post('/juego/{videojuego}/reseña', [GameStoreController::class, 'storeReview'])->name('store.review.add');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
