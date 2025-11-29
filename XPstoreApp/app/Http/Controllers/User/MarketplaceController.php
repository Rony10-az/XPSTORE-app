<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    public function index()
    {
        // Obtener todos los items activos
        $items = Item::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // Procesar imágenes para cada item
        foreach ($items as $item) {
            if ($item->image) {
                if (!str_starts_with($item->image, 'http')) {
                    if (!str_starts_with($item->image, 'storage/')) {
                        $item->image_url = asset('storage/' . $item->image);
                    } else {
                        $item->image_url = asset($item->image);
                    }
                } else {
                    $item->image_url = $item->image;
                }
            } else {
                $item->image_url = 'https://via.placeholder.com/300x200?text=Sin+Imagen';
            }
        }

        return view('market.index', compact('items'));
    }
}
