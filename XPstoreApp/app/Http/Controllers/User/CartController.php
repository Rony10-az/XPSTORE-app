<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\VideoGame;
use Illuminate\Http\Request;
use App\Models\MarketItem;
use Illuminate\Support\Facades\Session;


class CartController extends Controller
{
    // Mostrar carrito
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return view('cart.index', [
                'cart' => [],
                'subtotal' => 0,
                'discount_total' => 0,
                'total' => 0
            ]);
        }

        $subtotal = 0;
        $discount_total = 0;

        foreach ($cart as $item) {

            $subtotal += $item['price'] * $item['quantity'];

            if ($item['discount'] > 0) {
                $discount_total +=
                    ($item['price'] - $item['final_price']) * $item['quantity'];
            }
        }

        $total = $subtotal - $discount_total;

        return view('cart.index', compact('cart', 'subtotal', 'discount_total', 'total'));
    }


    // Agregar al carrito
    // Agregar al carrito
    public function add(Request $request, $id)
    {
        try {
            // Recibir el tipo enviado por el formulario
            $type = $request->input('type', 'video_game');

            $cart = session()->get('cart', []);

            /* ==========================================
         *   AGREGAR VIDEOJUEGO
         * ========================================== */
            if ($type === 'video_game') {

                $game = VideoGame::findOrFail($id);

                if (isset($cart["game_$id"])) {
                    $cart["game_$id"]['quantity']++;
                } else {

                    $image = $this->getFirstImage($game->images);
                    $genres = $this->normalizeJson($game->genre);
                    $final_price = $game->price_after_discount;

                    $cart["game_$id"] = [
                        'id'          => $game->id,
                        'type'        => 'video_game',
                        'title'       => $game->title,
                        'price'       => $game->price,
                        'final_price' => $final_price,
                        'discount'    => $game->discount,
                        'image'       => $image,
                        'genre'       => $genres,
                        'platform'    => $game->platform,
                        'quantity'    => 1,
                    ];
                }
            }

            /* ==========================================
         *   AGREGAR ÍTEM DEL MARKETPLACE
         * ========================================== */
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
                        'final_price' => $item->price, // marketplace no maneja desconto
                        'discount'    => 0,
                        'image'       => $item->image,
                        'genre'       => [],
                        'platform'    => [],
                        'quantity'    => 1,
                    ];
                }
            }

            /** =========================================
             * 3. AGREGAR STREAMING CODE
             * ========================================= */
            if ($type === 'streaming_code') {
                $code = \App\Models\StreamingCode::findOrFail($id);

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

            return redirect()
                ->route('cart.index')
                ->with('success', 'Juego agregado al carrito');
        } catch (\Exception $e) {
            report($e);

            return redirect()
                ->route('cart.index')
                ->with('error', 'Ocurrió un problema al agregar el producto al carrito.');
        }
    }



    // Eliminar
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Juego eliminado del carrito');
    }

    private function normalizeJson($value)
    {
        if (is_array($value)) return $value;

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
