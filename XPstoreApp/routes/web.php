<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Store\GameStoreController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\VideoGameController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\LibraryController;
use App\Http\Controllers\Community\CommunityController;
use App\Http\Controllers\Community\PostController;
use App\Http\Controllers\Community\CommentController;
use App\Http\Controllers\Items\MarketplaceController;
use App\Http\Controllers\Streaming\StreamingStoreController;
use App\Http\Controllers\User\PurchaseController;
use App\Http\Controllers\User\WishlistController;
use App\Http\Controllers\User\SettingsController;
use App\Models\User;




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

Route::get('/juegos', [GameStoreController::class, 'index'])
    ->name('store.index');

Route::get('/juego/{videojuego}', [GameStoreController::class, 'show'])
    ->name('game.show');


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


    // USER
    Route::get('/dashboard/user', [UserDashboardController::class, 'index'])
        ->name('dashboard.user');

    // BIBLIOTECA DE JUEGOS (MIS JUEGOS)
    Route::get('/mis-juegos', [LibraryController::class, 'index'])
        ->name('library.index');

    // MARKETPLACE
    Route::get('/marketplace', [MarketplaceController::class, 'index'])
        ->name('market.index');

    Route::get('/marketplace/item/{item}', [MarketplaceController::class, 'show'])
        ->name('market.show');

    // Streaming Codes
    // STREAMING STORE
    Route::get('/streaming', [StreamingStoreController::class, 'index'])
        ->name('streaming.index');

    Route::get('/streaming/{code}', [StreamingStoreController::class, 'show'])
        ->name('streaming.show');


    // COMUNIDAD 

    Route::get('/comunidad', [CommunityController::class, 'index'])->name('community.index');

    // Crear post
    Route::get('/comunidad/publicar', [PostController::class, 'create'])->name('community.create');
    Route::post('/comunidad/publicar', [PostController::class, 'store'])->name('community.store');

    // Comentarios
    Route::post('/comunidad/{post}/comment', [CommentController::class, 'store'])->name('community.comment');
    Route::post('/comunidad/review', [PostController::class, 'storeReview'])
        ->name('community.review');




    // PERFIL
    Route::get('/perfil', [ProfileController::class, 'index'])
        ->name('profile.index');

    Route::put('/perfil/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/compras', [PurchaseController::class, 'index'])->name('purchases.index');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])
        ->name('wishlist.toggle');
    Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'remove'])
        ->name('wishlist.remove');
    Route::get('/configuracion', [SettingsController::class, 'index'])->name('settings.index');




    // =========================
    // CARRITO DE COMPRAS 
    // =========================

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index'); // Ver carrito
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add'); // Agregar al carrito
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove'); // Eliminar del carrito

    // =========================
    // CHECKOUT
    // =========================
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/confirm', [CheckoutController::class, 'confirm'])->name('checkout.confirm');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])
        ->name('checkout.success');



    // STORE ACTIONS
    Route::post('/carrito/{videojuego}', [GameStoreController::class, 'addToCart'])->name('store.cart.add');
    Route::post('/favorito/{videojuego}', [GameStoreController::class, 'toggleWishlist'])->name('store.wishlist.toggle');
    Route::post('/juego/{videojuego}/reseña', [GameStoreController::class, 'storeReview'])->name('store.review.add');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
