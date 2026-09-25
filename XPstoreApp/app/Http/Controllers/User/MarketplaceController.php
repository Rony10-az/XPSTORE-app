<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MarketItem;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{

    public function index()
    {
        $items = MarketItem::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);


        // Procesar cada item
        foreach ($items as $item) {

            // Si la imagen es URL externa
            if (str_starts_with($item->image, 'http')) {
                $item->image_url = $item->image;
            } else {
                // Imagen local en storage
                $item->image_url = asset('storage/' . $item->image);
            }

            // Cambiar name → title (para la vista)
            $item->title = $item->name;
        }

        return view('marketplace.index', compact('items'));
    }
}
