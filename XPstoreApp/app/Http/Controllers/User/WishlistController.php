<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = Wishlist::with('item')
            ->where('user_id', Auth::id())
            ->get();

        return view('user.wishlist', compact('wishlist'));
    }


    public function toggle(Request $request)
    {
        $userId = Auth::id();

        $itemId = $request->input('item_id');
        $itemType = $request->input('item_type');

        if (!$itemId || !$itemType) {
            return response()->json(['status' => 'error', 'msg' => 'Datos inválidos'], 400);
        }

        $existing = Wishlist::where([
            'user_id' => $userId,
            'item_id' => $itemId,
            'item_type' => $itemType
        ])->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['status' => 'removed']);
        }

        Wishlist::create([
            'user_id' => $userId,
            'item_id' => $itemId,
            'item_type' => $itemType
        ]);

        return response()->json(['status' => 'added']);
    }


    public function remove($id)
    {
        $wishlist = Wishlist::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$wishlist) {
            return back()->with('error', 'No se pudo eliminar.');
        }

        $wishlist->delete();

        return back()->with('success', 'Eliminado de tu wishlist.');
    }
}
