<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\VideoGame;
use Illuminate\Http\Request;

class GameStoreController extends Controller
{
    // ===============================
    // LISTADO DE JUEGOS DE LA TIENDA
    // ===============================
    public function index()
    {
        $games = VideoGame::orderBy('featured', 'desc')
            ->orderBy('rating', 'desc')
            ->get();

        return view('store.index', compact('games'));
    }

    // ===============================
    // MOSTRAR UN JUEGO INDIVIDUAL
    // ===============================
    public function show(VideoGame $videojuego)
    {
        return view('store.games.show', [
            'game' => $videojuego
        ]);
    }


    // ===============================
    // TOGGLE WISHLIST
    // ===============================
    public function toggleWishlist(VideoGame $videojuego)
    {
        // Lógica para wishlist después
    }

    // ===============================
    // GUARDAR RESEÑA
    // ===============================
    public function storeReview(Request $request, VideoGame $videojuego)
    {
        // lógica de reseñas luego
    }
}
