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
        $purchases = UserPurchase::where('user_id', Auth::id())
            ->whereNotNull('video_game_id')
            ->with('videoGame')
            ->latest()
            ->get()
            ->filter(function($purchase) {
                // Solo mostrar compras donde el videojuego aún existe
                return $purchase->videoGame !== null;
            });

        // Agrupar compras por video_game_id
        $libraryItems = $purchases->groupBy('video_game_id')->map(function($group) {
            // Retornar el primer item del grupo con todos los códigos
            $firstPurchase = $group->first();
            $firstPurchase->activation_codes = $group->pluck('activation_code')->toArray();
            $firstPurchase->purchase_count = $group->count();
            $firstPurchase->purchase_dates = $group->pluck('created_at')->toArray();
            return $firstPurchase;
        })->values();

        return view('library.index', compact('libraryItems'));
    }


    public function videoGame()
    {
        return $this->belongsTo(VideoGame::class, 'video_game_id');
    }
}
