<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\VideoGame;

class DashboardController extends Controller
{
    public function index()
    {
        // DEBUG: Verificar juegos
        $totalGames = VideoGame::count();
        $gamesWithStock = VideoGame::where('stock', '>', 0)->count();
        \Log::info("Total juegos en DB: $totalGames");
        \Log::info("Juegos con stock > 0: $gamesWithStock");

        // ===== Featured Games (Todos los destacados) =====
        $featuredGames = VideoGame::where('featured', true)
            ->where('stock', '>', 0)
            ->get(['id', 'title', 'price', 'discount', 'rating', 'genre', 'developer', 'images', 'description']);

        foreach ($featuredGames as $game) {
            $images = is_string($game->images) ? json_decode($game->images, true) : $game->images;
            $firstImage = $images[0] ?? null;

            if ($firstImage) {
                if (!str_starts_with($firstImage, 'http')) {
                    if (!str_starts_with($firstImage, 'storage/')) {
                        $game->image = asset('storage/' . $firstImage);
                    } else {
                        $game->image = asset($firstImage);
                    }
                } else {
                    $game->image = $firstImage;
                }
            } else {
                $game->image = 'https://via.placeholder.com/800x400?text=Sin+Imagen';
            }

            // Convertir géneros a array
            $game->genres = is_array($game->genre) ? $game->genre : json_decode($game->genre ?? '[]', true);

            unset($game->images);
        }

        // ===== ALL GAMES (Catálogo completo) =====
        // Traer TODOS los juegos, incluso si stock es 0 o NULL
        $allGames = VideoGame::orderBy('created_at', 'desc')
            ->paginate(12);

        foreach ($allGames as $game) {
            $images = is_string($game->images) ? json_decode($game->images, true) : $game->images;

            // Si la imagen está guardada como ruta de storage, agregarle asset
            $firstImage = $images[0] ?? null;

            if ($firstImage) {
                // Si la ruta NO empieza con http (es decir, es una ruta local)
                if (!str_starts_with($firstImage, 'http')) {
                    // Si NO tiene 'storage/' al inicio, agregarlo
                    if (!str_starts_with($firstImage, 'storage/')) {
                        $game->image = asset('storage/' . $firstImage);
                    } else {
                        $game->image = asset($firstImage);
                    }
                } else {
                    // Es una URL externa, dejarla tal cual
                    $game->image = $firstImage;
                }
            } else {
                // Imagen por defecto si no hay ninguna
                $game->image = 'https://via.placeholder.com/300x200?text=Sin+Imagen';
            }

            unset($game->images);
        }

        return view('dashboard.user', compact(
            'featuredGames',
            'allGames'
        ));
    }
}
