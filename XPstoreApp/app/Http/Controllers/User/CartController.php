<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\VideoGame;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Mostrar carrito
    public function index()
    {
        $cart = session()->get('cart', []);

        // Si el carrito está vacío
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

            // precio original * cantidad
            $subtotal += $item['price'] * $item['quantity'];

            // si tiene descuento
            if ($item['discount'] > 0) {
                $discount_total += ($item['price'] - $item['final_price']) * $item['quantity'];
            }
        }

        // total final
        $total = $subtotal - $discount_total;

        return view('cart.index', compact('cart', 'subtotal', 'discount_total', 'total'));
    }


    // Agregar al carrito
    public function add($id)
    {
        $game = VideoGame::findOrFail($id);

        // Obtener carrito actual
        $cart = session()->get('cart', []);

        // Si ya existe, aumentar cantidad
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // Agregar por primera vez
            $cart[$id] = [
                'title'     => $game->titulo,
                'price'     => $game->precio,
                'image'     => $game->imagen ? asset('img/videojuegos/' . $game->imagen) : 'https://via.placeholder.com/120',
                'quantity'  => 1,
                'discount'  => $game->descuento,
                'final_price' => $game->precio_con_descuento ?? $game->precio
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')
            ->with('success', 'Juego agregado al carrito');
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
}
