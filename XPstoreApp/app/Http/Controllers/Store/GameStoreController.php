<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VideoGame;

class GameStoreController extends Controller
{
    public function index()
    {
        $games = VideoGame::orderBy('featured', 'desc')->get();
        return view('layouts.app', compact('games'));
    }

    public function show(VideoGame $videojuego)
    {
        return view('store.games.show', [
            'game' => $videojuego
        ]);
    }

    public function addToCart(VideoGame $videojuego)
    {
        // lógica carrito
    }

    public function toggleWishlist(VideoGame $videojuego)
    {
        // lógica wishlist
    }

    public function storeReview(Request $request, VideoGame $videojuego)
    {
        // lógica de reseñas
    }
}
