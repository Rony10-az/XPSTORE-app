<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

        // Guardamos el total en sesión para validaciones futuras
        session(['cart_total' => $total]);

        return view('checkout.index', compact('cart', 'subtotal', 'discount_total', 'total'));
    }

    public function confirm(Request $request)
    {
        // ============================
        // SI EL PAGO VIENE DESDE PAYPAL
        // ============================
        if ($request->has('paypal_order_id')) {

            $paypalOrderId = $request->paypal_order_id;
            $payer = $request->payer;

            // Aquí puedes crear Order + OrderItems  
            // o Registrar un Payment en tu DB.

            /*
            Payment::create([
                'user_id' => auth()->id(),
                'method' => 'paypal',
                'paypal_id' => $paypalOrderId,
                'payer_email' => $payer['email_address'] ?? null,
                'total' => session('cart_total'),
            ]);
            */

            // Vaciar carrito
            session()->forget('cart');
            session()->forget('cart_total');

            return response()->json([
                'success' => true,
                'message' => 'Pago completado con PayPal'
            ]);
        }

        // ============================
        // PAGO NORMAL (TARJETA O BANCO)
        // ============================
        session()->forget('cart');
        session()->forget('cart_total');

        return redirect()->route('dashboard.user')
            ->with('success', 'Pago realizado correctamente');
    }
    public function success()
    {
        return view('checkout.success');
    }
}
