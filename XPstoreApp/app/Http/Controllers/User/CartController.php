<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\VideoGame;
use App\Models\MarketItem;
use App\Models\StreamingCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /* ============================================================
     *  MOSTRAR CARRITO
     * ============================================================ */
    public function index()
    {
        $cart = session('cart', []);

        $subtotal = 0;
        $discount_total = 0;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];

            if ($item['discount'] > 0) {
                $discount_total += ($item['price'] - $item['final_price']) * $item['quantity'];
            }
        }

        $total = $subtotal - $discount_total;

        return view('cart.index', compact('cart', 'subtotal', 'discount_total', 'total'));
    }


    /* ============================================================
     *  AGREGAR AL CARRITO
     * ============================================================ */
    public function add(Request $request, $id)
    {
        $type = $request->input('type', 'video_game');
        $cart = session()->get('cart', []);

        /* ==== VIDEOJUEGO ==== */
        if ($type === 'video_game') {

            $game = VideoGame::findOrFail($id);

            if (isset($cart["game_$id"])) {
                $cart["game_$id"]['quantity']++;
            } else {
                $image = $this->getFirstImage($game->images);

                $cart["game_$id"] = [
                    'id'          => $game->id,
                    'type'        => 'video_game',
                    'title'       => $game->title,
                    'price'       => $game->price,
                    'final_price' => $game->price_after_discount,
                    'discount'    => $game->discount,
                    'image'       => $image,
                    'genre'       => $this->normalizeJson($game->genre),
                    'platform'    => $game->platform,
                    'quantity'    => 1,
                ];
            }
        }

        /* ==== MARKET ITEM ==== */
        if ($type === 'market_item') {

            $item = MarketItem::findOrFail($id);

            if (isset($cart["item_$id"])) {
                $cart["item_$id"]['quantity']++;
            } else {
                $cart["item_$id"] = [
                    'id'          => $item->id,
                    'type'        => 'market_item',
                    'title'       => $item->title,
                    'price'       => $item->price,
                    'final_price' => $item->price,
                    'discount'    => 0,
                    'image'       => $item->image,
                    'quantity'    => 1,
                ];
            }
        }

        /* ==== STREAMING CODE ==== */
        if ($type === 'streaming_code') {

            $code = StreamingCode::findOrFail($id);

            if (isset($cart["stream_$id"])) {
                $cart["stream_$id"]['quantity']++;
            } else {
                $cart["stream_$id"] = [
                    'id'          => $code->id,
                    'type'        => 'streaming_code',
                    'title'       => "{$code->service} ({$code->duration})",
                    'price'       => $code->price,
                    'final_price' => $code->price,
                    'discount'    => 0,
                    'image'       => $code->image,
                    'quantity'    => 1,
                ];
            }
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Producto agregado al carrito.');
    }


    /* ============================================================
     *  ELIMINAR PRODUCTO
     * ============================================================ */
    public function remove(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Producto eliminado.');
    }


    /* ============================================================
     *  ACTUALIZAR CANTIDAD
     * ============================================================ */
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $action = $request->action;

            if ($action === 'increase') {
                $cart[$id]['quantity']++;
            } elseif ($action === 'decrease' && $cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity']--;
            }
        }

        session()->put('cart', $cart);
        return back()->with('success', 'Cantidad actualizada');
    }


    /* ============================================================
     *  HELPERS
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
        return $arr[0] ?? asset("images/no-image.png");
    }
}
