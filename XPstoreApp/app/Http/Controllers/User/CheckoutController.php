<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);

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

        return view('checkout.index', compact('cart', 'subtotal', 'discount_total', 'total'));
    }
}
