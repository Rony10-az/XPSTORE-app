<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\VideoGame;

class DashboardController extends Controller
{
    public function index()
    {
        // ======================================
        // FEATURED GAME
        // ======================================
        $featuredGame = VideoGame::where('featured', true)
            ->where('stock', '>', 0)
            ->first(['id', 'title', 'price', 'discount', 'rating', 'genre', 'platform', 'developer', 'images']);

        if ($featuredGame) {
            $featuredGame->image = $this->getFirstImage($featuredGame->images);
            unset($featuredGame->images);
        }


        // ======================================
        // POPULAR GAMES
        // ======================================
        $popularGames = VideoGame::where('stock', '>', 0)
            ->orderBy('rating', 'desc')
            ->take(4)
            ->get(['id', 'title', 'price', 'discount', 'rating', 'genre', 'platform', 'developer', 'images']);


        $popularGames->transform(function ($game) {
            $game->image = $this->getFirstImage($game->images);
            unset($game->images);
            return $game;
        });


        // ======================================
        // DISCOUNTED GAMES (MEJORES OFERTAS)
        // ======================================
        $bestOffers = VideoGame::where('discount', '>', 0)
            ->where('stock', '>', 0)
            ->orderBy('discount', 'desc')
            ->take(6)
            ->get(['id', 'title', 'price', 'discount', 'rating', 'genre', 'platform', 'developer', 'images']);

        $bestOffers->transform(function ($game) {
            $game->image = $this->getFirstImage($game->images);
            unset($game->images);
            return $game;
        });


        // ======================================
        // TOP RATED (MEJOR VALORADOS)
        // ======================================
        $topRated = VideoGame::where('stock', '>', 0)
            ->orderBy('rating', 'desc')
            ->take(6)
            ->get(['id', 'title', 'price', 'discount', 'rating', 'genre', 'platform', 'developer', 'images']);

        $topRated->transform(function ($game) {
            $game->image = $this->getFirstImage($game->images);
            unset($game->images);
            return $game;
        });


        // ======================================
        // ALL GAMES (CATÁLOGO COMPLETO)
        // ======================================
        $allGames = VideoGame::where('stock', '>', 0)
            ->orderBy('title', 'asc')
            ->get(['id', 'title', 'price', 'discount', 'rating', 'platform', 'genre', 'developer', 'images']);

        $allGames->transform(function ($game) {
            $game->image = $this->getFirstImage($game->images);
            unset($game->images);
            return $game;
        });


        // ======================================
        // NEW RELEASES
        // ======================================
        $newReleases = VideoGame::where('stock', '>', 0)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get(['id', 'title', 'price', 'discount', 'rating', 'genre', 'platform', 'developer', 'images']);

        $newReleases->transform(function ($game) {
            $game->image = $this->getFirstImage($game->images);
            unset($game->images);
            return $game;
        });


        return view('dashboard.user', compact(
            'featuredGame',
            'popularGames',
            'newReleases',
            'bestOffers',
            'topRated',
            'allGames'
        ));
    }


    private function normalizeJson($value)
    {
        if (is_array($value)) return $value;

        // Si llega como ['img1','img2'] convertirlo a JSON válido
        if (is_string($value) && str_contains($value, "'")) {
            $value = str_replace("'", '"', $value);
        }

        $decoded = json_decode($value, true);
        return $decoded ?? [];
    }
    private function getFirstImage($images)
    {
        $arr = $this->normalizeJson($images);

        if (empty($arr)) {
            return asset("images/no-image.png");
        }

        return $arr[0];
    }
}
