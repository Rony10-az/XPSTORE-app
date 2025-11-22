<?php

/**
 * Controlador del Carrito de Compras del usuario.
 *
 * Este controlador administra toda la lógica del carrito:
 * - Mostrar el carrito actual desde la sesión.
 * - Agregar productos al carrito (sumar cantidades si ya existe).
 * - Calcular subtotal, descuentos y total final.
 * - Eliminar productos del carrito.
 *
 * El carrito se almacena en la sesión como un array asociativo:
 * cart[id_producto] = [
 *      'title'        => string,
 *      'price'        => float,
 *      'image'        => string (ruta absoluta),
 *      'quantity'     => int,
 *      'discount'     => int,
 *      'final_price'  => float
 * ]
 */


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
    public function add($id)
    {
        try {
            $game = VideoGame::findOrFail($id);

            $cart = session()->get('cart', []);

            if (isset($cart[$id])) {

                $cart[$id]['quantity']++;
            } else {

                // Intento de obtener la imagen real
                $image = 'https://via.placeholder.com/120';

                if (is_array($game->images) && count($game->images) > 0) {
                    $possiblePath = 'storage/' . $game->images[0];

                    // Si existe la imagen en storage
                    if (file_exists(public_path($possiblePath))) {
                        $image = asset($possiblePath);
                    }
                }

                // Precio final (accessor)
                $final_price = $game->price_after_discount;

                $cart[$id] = [
                    'title'       => $game->title,
                    'price'       => $game->price,
                    'image'       => $image,
                    'discount'    => $game->discount,
                    'final_price' => $final_price,
                    'quantity'    => 1,
                ];
            }

            session()->put('cart', $cart);

            return redirect()
                ->route('cart.index')
                ->with('success', 'Juego agregado al carrito');
        } catch (\Exception $e) {

            // registrar error en logs
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
}
