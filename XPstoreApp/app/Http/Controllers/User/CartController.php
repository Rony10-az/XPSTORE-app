<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\VideoGame;
use App\Models\Item;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Mostrar carrito
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = session()->get('cart_items', []);

        if (empty($cart) && empty($cartItems)) {
            return view('cart.index', [
                'cart' => [],
                'cartItems' => [],
                'subtotal' => 0,
                'discount_total' => 0,
                'total' => 0
            ]);
        }

        $subtotal = 0;
        $discount_total = 0;

        // Calcular totales de videojuegos
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];

            if ($item['discount'] > 0) {
                $discount_total +=
                    ($item['price'] - $item['final_price']) * $item['quantity'];
            }
        }

        // Calcular totales de items
        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $total = $subtotal - $discount_total;

        return view('cart.index', compact('cart', 'cartItems', 'subtotal', 'discount_total', 'total'));
    }


    // Agregar al carrito
    public function add(Request $request, $id)
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

                    if (file_exists(public_path($possiblePath))) {
                        $image = asset($possiblePath);
                    }
                }

                // Precio final (accessor)
                $final_price = $game->price_after_discount;

                // AGREGAMOS EL ID SIN ROMPER NADA
                $cart[$id] = [
                    'id'          => $game->id,   // ← ← AQUI ESTÁ LO IMPORTANTE
                    'title'       => $game->title,
                    'price'       => $game->price,
                    'image'       => $image,
                    'discount'    => $game->discount,
                    'final_price' => $final_price,
                    'quantity'    => 1,
                ];
            }

            session()->put('cart', $cart);

            // Calcular total de productos en el carrito
            $cartCount = collect($cart)->sum('quantity');

            // Si es una petición AJAX, devolver JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Juego agregado al carrito',
                    'cartCount' => $cartCount
                ]);
            }

            // Si no es AJAX, redirigir como antes
            return redirect()
                ->route('cart.index')
                ->with('success', 'Juego agregado al carrito');
        } catch (\Exception $e) {

            // registrar error en logs
            report($e);

            // Si es AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al agregar el producto al carrito'
                ], 500);
            }

            return redirect()
                ->route('cart.index')
                ->with('error', 'Ocurrió un problema al agregar el producto al carrito.');
        }
    }


    // Agregar item del marketplace al carrito
    public function addItem(Request $request, $id)
    {
        try {
            $item = Item::findOrFail($id);

            $cartItems = session()->get('cart_items', []);

            if (isset($cartItems[$id])) {
                $cartItems[$id]['quantity']++;
            } else {
                // Procesar imagen
                $image = 'https://via.placeholder.com/120';

                if ($item->image) {
                    if (!str_starts_with($item->image, 'http')) {
                        if (!str_starts_with($item->image, 'storage/')) {
                            $image = asset('storage/' . $item->image);
                        } else {
                            $image = asset($item->image);
                        }
                    } else {
                        $image = $item->image;
                    }
                }

                $cartItems[$id] = [
                    'name'        => $item->name,
                    'price'       => $item->price,
                    'image'       => $image,
                    'type'        => $item->type,
                    'rarity'      => $item->rarity,
                    'quantity'    => 1,
                ];
            }

            session()->put('cart_items', $cartItems);

            // Calcular total de productos en el carrito (videojuegos + items)
            $cart = session()->get('cart', []);
            $cartCount = collect($cart)->sum('quantity') + collect($cartItems)->sum('quantity');

            // Si es una petición AJAX, devolver JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item agregado al carrito',
                    'cartCount' => $cartCount
                ]);
            }

            // Si no es AJAX, redirigir como antes
            return redirect()
                ->route('cart.index')
                ->with('success', 'Item agregado al carrito');
        } catch (\Exception $e) {
            // registrar error en logs
            report($e);

            // Si es AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al agregar el item al carrito'
                ], 500);
            }

            return redirect()
                ->route('marketplace.index')
                ->with('error', 'Ocurrió un problema al agregar el item al carrito.');
        }
    }

    // Actualizar cantidad
    public function update(Request $request, $id)
    {
        $type = $request->input('type', 'game');

        if ($type === 'item') {
            $cartItems = session()->get('cart_items', []);

            if (isset($cartItems[$id])) {
                $action = $request->input('action');

                if ($action === 'increase') {
                    $cartItems[$id]['quantity']++;
                } elseif ($action === 'decrease' && $cartItems[$id]['quantity'] > 1) {
                    $cartItems[$id]['quantity']--;
                }

                session()->put('cart_items', $cartItems);
                return back()->with('success', 'Cantidad actualizada');
            }
        } else {
            $cart = session()->get('cart', []);

            if (isset($cart[$id])) {
                $action = $request->input('action');

                if ($action === 'increase') {
                    $cart[$id]['quantity']++;
                } elseif ($action === 'decrease' && $cart[$id]['quantity'] > 1) {
                    $cart[$id]['quantity']--;
                }

                session()->put('cart', $cart);
                return back()->with('success', 'Cantidad actualizada');
            }
        }

        return back()->with('error', 'Producto no encontrado en el carrito');
    }

    // Eliminar
    public function remove(Request $request, $id)
    {
        $type = $request->input('type', 'game');

        if ($type === 'item') {
            $cartItems = session()->get('cart_items', []);

            if (isset($cartItems[$id])) {
                unset($cartItems[$id]);
                session()->put('cart_items', $cartItems);
            }

            return back()->with('success', 'Item eliminado del carrito');
        } else {
            $cart = session()->get('cart', []);

            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            }

            return back()->with('success', 'Juego eliminado del carrito');
        }
    }
}
