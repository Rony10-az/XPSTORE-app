<?php


use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\LibraryController;
use App\Http\Controllers\Community\CommunityController;
use App\Http\Controllers\Community\PostController;
use App\Http\Controllers\Community\CommentController;
use App\Http\Controllers\Admin\AdminProfileController;
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
use App\Http\Controllers\User\MarketplaceController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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


    // ADMIN
    Route::get('/dashboard/admin', [AdminDashboardController::class, 'index'])->name('dashboard.admin');

    // CRUD de Videojuegos (solo admins)
    Route::resource('videojuegos', VideoGameController::class)->names('videojuegos');

    // Rutas de usuarios (solo admin)
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        // Monté este recurso para listar, ver, editar y eliminar usuarios.
        Route::resource('users', AdminUserController::class)->except(['create', 'store']);
    });

    // Rutas de administración (solo admins)
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        // CRUD de Videojuegos
        Route::resource('videojuegos', VideoGameController::class);
    });

    /* dados de prueba para ver si se sube bien el cambio */
    // Rutas de administración (solo admins)
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        // Perfil del admin
        Route::get('profile', [AdminProfileController::class, 'index'])->name('profile.index');
        Route::put('profile', [AdminProfileController::class, 'updateProfile'])->name('profile.update');
        Route::put('profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.password');
        Route::delete('profile/avatar', [AdminProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');

        Route::resource('videojuegos', VideoGameController::class);
        Route::resource('users', AdminUserController::class)->except(['create', 'store']);
        Route::resource('gamecodes', GameCodeController::class);
        Route::post('gamecodes/{gamecode}/mark-used', [GameCodeController::class, 'markAsUsed'])->name('gamecodes.markUsed');
        Route::post('gamecodes/{gamecode}/mark-expired', [GameCodeController::class, 'markAsExpired'])->name('gamecodes.markExpired');
        Route::post('gamecodes/destroy-batch', [GameCodeController::class, 'destroyBatch'])->name('gamecodes.destroyBatch');
        Route::resource('reviews', ReviewController::class)->only(['index', 'destroy']);
        Route::get('reviews/verified-buyers', [ReviewController::class, 'verifiedBuyers'])->name('reviews.verified');
        Route::post('reviews/{review}/sentiment', [ReviewController::class, 'updateSentiment'])->name('reviews.sentiment');
        Route::post('reviews/{review}/warning', [ReviewController::class, 'addWarning'])->name('reviews.warning');
        Route::post('reviews/{review}/toggle-block', [ReviewController::class, 'toggleBlock'])->name('reviews.toggleBlock');
        Route::resource('items', ItemController::class);
        Route::get('settings', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings');
        Route::post('settings', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
    });

    // USER
    Route::get('/dashboard/user', [UserDashboardController::class, 'index'])
        ->name('dashboard.user');

    // BIBLIOTECA DE JUEGOS (MIS JUEGOS)
    Route::get('/mis-juegos', [LibraryController::class, 'index'])
        ->name('library.index');

    // MARKETPLACE
    Route::get('/marketplace', [MarketplaceController::class, 'index'])
        ->name('marketplace.index');

    Route::get('/marketplace/item/{item}', [MarketplaceController::class, 'show'])
        ->name('marketplace.show');

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
    Route::get('/perfil', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/perfil/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/perfil/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/perfil/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');

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

    // Carrito
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/add-item/{id}', [CartController::class, 'addItem'])->name('cart.add.item');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // STORE ACTIONS
    Route::post('/carrito/{videojuego}', [GameStoreController::class, 'addToCart'])->name('store.cart.add');
    Route::post('/favorito/{videojuego}', [GameStoreController::class, 'toggleWishlist'])->name('store.wishlist.toggle');
    Route::post('/juego/{videojuego}/reseña', [GameStoreController::class, 'storeReview'])->name('store.review.add');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
