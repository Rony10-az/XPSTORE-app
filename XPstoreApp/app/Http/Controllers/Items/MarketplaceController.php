<?php

namespace App\Http\Controllers\Items;

use App\Http\Controllers\Controller;
use App\Models\MarketItem;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    /**
     * Página principal del Marketplace.
     */
    public function index()
    {
        $userId = Auth::id();

        $items = MarketItem::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) use ($userId) {

                // Resolver imagen
                $item->resolved_image = $this->resolveImage($item->image);

                // Saber si este ítem está en wishlist
                $item->is_wished = Wishlist::where('user_id', $userId)
                    ->where('item_id', $item->id)
                    ->where('item_type', MarketItem::class)
                    ->exists();

                return $item;
            });

        return view('marketplace.index', compact('items'));
    }

    /**
     * Ver detalle de un ítem.
     */
    public function show(MarketItem $item)
    {
        $image = $this->resolveImage($item->image);
        $attributes = $item->attributes ?? [];

        return view('marketplace.show', compact('item', 'image', 'attributes'));
    }

    /**
     * Agregar ítem del Marketplace al carrito.
     */
    public function add(Request $request, $id)
    {
        $item = MarketItem::findOrFail($id);

        $cart = session()->get('cart', []);

        $existing = null;

        foreach ($cart as $index => $product) {
            if ($product['type'] === 'market_item' && $product['id'] == $item->id) {
                $existing = $index;
                break;
            }
        }

        if ($existing !== null) {
            $cart[$existing]['quantity'] += 1;
        } else {
            $cart[] = [
                'id' => $item->id,
                'type' => 'market_item',
                'title' => $item->title,
                'price' => $item->price,
                'image' => $this->resolveImage($item->image),
                'quantity' => 1
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Ítem agregado al carrito.');
    }

    /**
     * Resolver URL de imagen.
     */
    private function resolveImage($path)
    {
        if (!$path) {
            return 'https://via.placeholder.com/350x350?text=No+Image';
        }

        if (str_starts_with($path, 'http')) {
            return $path;
        }

        return asset($path);
    }
}
