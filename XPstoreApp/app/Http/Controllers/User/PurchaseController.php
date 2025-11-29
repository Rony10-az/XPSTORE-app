<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserPurchase;
use Illuminate\Support\Facades\Auth;
use App\Models\MarketItem;
use App\Models\StreamingCode;

class PurchaseController extends Controller
{
    public function index()
    {
        $libraryItems = UserPurchase::with([
            'videoGame',
            'marketItem',
            'streamingCode'
        ])
            ->where('user_id', Auth::id())
            ->get();

        return view('library.index', compact('libraryItems'));
    }
}
