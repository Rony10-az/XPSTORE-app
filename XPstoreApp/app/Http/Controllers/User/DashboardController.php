<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\VideoGame;

class DashboardController extends Controller
{
    public function index()
    {
        // ===== Featured Game =====
        $featuredGame = VideoGame::where('featured', true)
            ->where('stock', '>', 0)
            ->first(['id', 'title', 'price', 'discount', 'rating', 'genre', 'developer', 'images']);

        if ($featuredGame) {
            $images = is_string($featuredGame->images) ? json_decode($featuredGame->images, true) : $featuredGame->images;
            $featuredGame->image = $images[0] ?? null;
            unset($featuredGame->images);
        }

        // ===== Popular Games =====
        $popularGames = VideoGame::where('stock', '>', 0)
            ->orderBy('rating', 'desc')
            ->take(4)
            ->get(['id', 'title', 'price', 'discount', 'rating', 'genre', 'developer', 'images']);

        foreach ($popularGames as $game) {
            $images = is_string($game->images) ? json_decode($game->images, true) : $game->images;
            $game->image = $images[0] ?? null;
            unset($game->images);
        }

        // ===== Discounted Games =====
        $discountedGames = VideoGame::where('discount', '>', 0)
            ->where('stock', '>', 0)
            ->orderBy('discount', 'desc')
            ->take(4)
            ->get(['id', 'title', 'price', 'discount', 'rating', 'genre', 'developer', 'images']);

        foreach ($discountedGames as $game) {
            $images = is_string($game->images) ? json_decode($game->images, true) : $game->images;
            $game->image = $images[0] ?? null;
            unset($game->images);
        }

        // ===== New Releases =====
        $newReleases = VideoGame::where('stock', '>', 0)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get(['id', 'title', 'price', 'discount', 'rating', 'genre', 'developer', 'images']);

        foreach ($newReleases as $game) {
            $images = is_string($game->images) ? json_decode($game->images, true) : $game->images;
            $game->image = $images[0] ?? null;
            unset($game->images);
        }

        return view('dashboard.user', compact(
            'featuredGame',
            'popularGames',
            'discountedGames',
            'newReleases'
        ));
    }
}
