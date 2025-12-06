<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserPurchase;
use Illuminate\Support\Facades\Auth;
use App\Models\VideoGame;

class LibraryController extends Controller
{
    public function index()
    {
        // Obtener todas las compras del usuario (videojuegos, marketplace, streaming)
        $purchases = UserPurchase::where('user_id', Auth::id())
            ->with(['videoGame', 'marketItem', 'streamingCode'])
            ->latest()
            ->get();

        // Obtener IDs de videojuegos que el usuario ha comentado
        $reviewedGameIds = \App\Models\GameReview::where('user_id', Auth::id())
            ->pluck('video_game_id')
            ->toArray();

        // Agrupar por tipo de item
        $libraryItems = collect();

        // Videojuegos: agrupar por video_game_id para mostrar múltiples códigos
        $gamesPurchases = $purchases->filter(fn($p) => $p->video_game_id !== null);
        $groupedGames = $gamesPurchases->groupBy('video_game_id')->map(function($group) {
            $firstPurchase = $group->first();
            $firstPurchase->activation_codes = $group->pluck('activation_code')->filter()->toArray();
            $firstPurchase->purchase_count = $group->count();
            $firstPurchase->purchase_dates = $group->pluck('created_at')->toArray();
            return $firstPurchase;
        });

        // Marketplace items: agrupar por market_item_id
        $marketPurchases = $purchases->filter(fn($p) => $p->market_item_id !== null);
        $groupedMarket = $marketPurchases->groupBy('market_item_id')->map(function($group) {
            $firstPurchase = $group->first();
            $firstPurchase->activation_codes = $group->pluck('activation_code')->filter()->toArray();
            $firstPurchase->purchase_count = $group->count();
            $firstPurchase->purchase_dates = $group->pluck('created_at')->toArray();
            return $firstPurchase;
        });

        // Streaming codes: agrupar por streaming_code_id
        $streamingPurchases = $purchases->filter(fn($p) => $p->streaming_code_id !== null);
        $groupedStreaming = $streamingPurchases->groupBy('streaming_code_id')->map(function($group) {
            $firstPurchase = $group->first();
            $firstPurchase->activation_codes = $group->pluck('activation_code')->filter()->toArray();
            $firstPurchase->purchase_count = $group->count();
            $firstPurchase->purchase_dates = $group->pluck('created_at')->toArray();
            return $firstPurchase;
        });

        // Combinar todos los items en una sola colección
        $libraryItems = $groupedGames->merge($groupedMarket)->merge($groupedStreaming)->values();

        return view('library.index', compact('libraryItems', 'reviewedGameIds'));
    }
}
