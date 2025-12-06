<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserPurchase;
use App\Models\GameCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Tu carrito está vacío');
        }

        $subtotal = 0;
        $discount_total = 0;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];

            if ($item['discount'] > 0) {
                $discount_total += ($item['price'] - $item['final_price']) * $item['quantity'];
            }
        }

        $total = $subtotal - $discount_total;

        session(['cart_total' => $total]);

        return view('checkout.index', compact('cart', 'subtotal', 'discount_total', 'total'));
    }



    // ====================================
    // 🔥 FUNCIÓN QUE GUARDA LAS COMPRAS
    // ====================================
    private function saveUserPurchases()
    {
        $cart = session()->get('cart', []);

        foreach ($cart as $item) {

            // Si por alguna razón no tiene ID o tipo, evitamos errores
            if (!isset($item['id']) || !isset($item['type'])) {
                continue;
            }

            // Determinar el tipo de item y guardar la compra correspondiente
            $type = $item['type'];

            // Procesar según el tipo de item
            for ($i = 0; $i < $item['quantity']; $i++) {

                if ($type === 'video_game') {
                    // ========== VIDEOJUEGO ==========
                    // Buscar un código de activación disponible
                    $gameCode = GameCode::where('video_game_id', $item['id'])
                                        ->where('status', 'disponible')
                                        ->whereNull('user_id')
                                        ->first();

                    if ($gameCode) {
                        $activationCode = $gameCode->code;
                        $gameCode->markAsUsed(Auth::id());
                    } else {
                        $activationCode = Str::upper(Str::random(16));
                    }

                    UserPurchase::create([
                        'user_id' => Auth::id(),
                        'video_game_id' => $item['id'],
                        'price_paid' => $item['final_price'],
                        'activation_code' => $activationCode,
                    ]);

                } elseif ($type === 'market_item') {
                    // ========== MARKETPLACE ITEM ==========
                    UserPurchase::create([
                        'user_id' => Auth::id(),
                        'market_item_id' => $item['id'],
                        'price_paid' => $item['final_price'],
                        'activation_code' => null, // Los items del marketplace no tienen código
                    ]);

                } elseif ($type === 'streaming_code') {
                    // ========== STREAMING CODE ==========
                    // Obtener el código del streaming
                    $streamingCode = \App\Models\StreamingCode::find($item['id']);

                    UserPurchase::create([
                        'user_id' => Auth::id(),
                        'streaming_code_id' => $item['id'],
                        'price_paid' => $item['final_price'],
                        'activation_code' => $streamingCode ? $streamingCode->code : null,
                    ]);
                }
            }
        }
    }



    // ====================================
    // CONFIRMAR PAGO
    // ====================================
    public function confirm(Request $request)
    {
        // Verificar si es un pago PayPal
        if ($request->has('paypal_order_id')) {

            // Guardar compras
            $this->saveUserPurchases();

            // Vaciar carrito
            session()->forget(['cart', 'cart_total']);

            return response()->json([
                'success' => true,
                'redirect' => route('dashboard.user'),
                'message' => 'Pago completado con PayPal'
            ]);
        }

        // Pago NORMAL ↓↓↓↓↓↓↓↓↓↓↓↓↓↓

        $this->saveUserPurchases();
        session()->forget(['cart', 'cart_total']);

        return redirect()
            ->route('dashboard.user')
            ->with('success', 'Pago realizado correctamente');
    }




    public function success()
    {
        return view('checkout.success');
    }
}
