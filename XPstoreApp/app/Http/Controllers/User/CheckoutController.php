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

            // Si por alguna razón no tiene ID, evitamos errores
            if (!isset($item['id'])) {
                continue;
            }

            // Buscar un código de activación disponible para este videojuego
            $gameCode = GameCode::where('video_game_id', $item['id'])
                                ->where('status', 'disponible')
                                ->whereNull('user_id')
                                ->first();

            // Si encontramos un código disponible, lo usamos
            if ($gameCode) {
                $activationCode = $gameCode->code;

                // Marcar el código como usado y asignarlo al usuario
                $gameCode->markAsUsed(Auth::id());
            } else {
                // Si no hay códigos disponibles, generamos uno automático como fallback
                $activationCode = Str::upper(Str::random(16));
            }

            UserPurchase::create([
                'user_id' => Auth::id(),
                'video_game_id' => $item['id'],        // ← usamos el ID agregado al carrito
                'price_paid'    => $item['final_price'],
                'activation_code' => $activationCode,
            ]);
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
