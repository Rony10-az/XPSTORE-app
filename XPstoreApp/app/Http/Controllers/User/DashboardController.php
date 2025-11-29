<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\VideoGame;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        Log::info("Total juegos: " . VideoGame::count());

        /* ============================================================
         * FEATURED GAMES (LISTA COMPLETA)
         * ============================================================ */
        $featuredGames = VideoGame::where('featured', true)
            ->where('stock', '>', 0)
            ->get();

        $featuredGames->transform(function ($g) {
            $g->image = $this->getFirstImage($g->images);
            return $g;
        });

        /* ============================================================
         * FEATURED GAME PRINCIPAL (UNO)
         * ============================================================ */
        $featuredGame = VideoGame::where('featured', true)
            ->where('stock', '>', 0)
            ->first();

        if ($featuredGame) {
            $featuredGame->image = $this->getFirstImage($featuredGame->images);
        }

        /* ============================================================
         * POPULAR GAMES
         * ============================================================ */
        $popularGames = VideoGame::where('stock', '>', 0)
            ->orderBy('rating', 'desc')
            ->take(4)
            ->get();

        $popularGames->transform(function ($game) {
            $game->image = $this->getFirstImage($game->images);
            return $game;
        });

        /* ============================================================
         * BEST OFFERS (DESCUENTOS)
         * ============================================================ */
        $bestOffers = VideoGame::where('discount', '>', 0)
            ->where('stock', '>', 0)
            ->orderBy('discount', 'desc')
            ->take(6)
            ->get();

        $bestOffers->transform(function ($game) {
            $game->image = $this->getFirstImage($game->images);
            return $game;
        });

        /* ============================================================
         * TOP RATED (MEJOR VALORADOS)
         * ============================================================ */
        $topRated = VideoGame::where('stock', '>', 0)
            ->orderBy('rating', 'desc')
            ->take(6)
            ->get();

        $topRated->transform(function ($game) {
            $game->image = $this->getFirstImage($game->images);
            return $game;
        });

        /* ============================================================
         * NEW RELEASES
         * ============================================================ */
        $newReleases = VideoGame::where('stock', '>', 0)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        $newReleases->transform(function ($game) {
            $game->image = $this->getFirstImage($game->images);
            return $game;
        });
        $allGames = VideoGame::where('stock', '>', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        $allGames->transform(function ($game) {
            $game->image = $this->getFirstImage($game->images);
            return $game;
        });


        /* ============================================================
         * RETORNAR VISTA
         * ============================================================ */
        return view('dashboard.user', compact(
            'featuredGames',
            'featuredGame',
            'popularGames',
            'newReleases',
            'bestOffers',
            'topRated',
            'allGames'
        ));
    }


    /* ============================================================
     * HELPERS
     * ============================================================ */
    private function normalizeJson($value)
    {
        if (is_array($value)) return $value;

        if (is_string($value) && str_contains($value, "'")) {
            $value = str_replace("'", '"', $value);
        }

        return json_decode($value, true) ?? [];
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
