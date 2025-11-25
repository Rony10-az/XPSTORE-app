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
        $libraryItems = UserPurchase::where('user_id', Auth::id())
            ->whereNotNull('video_game_id')  // ← evita registros corruptos
            ->with('videoGame')
            ->latest()
            ->get();


        return view('library.index', compact('libraryItems'));
    }


    public function videoGame()
    {
        return $this->belongsTo(VideoGame::class, 'video_game_id');
    }
}
