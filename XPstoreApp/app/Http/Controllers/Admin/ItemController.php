<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MarketItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = MarketItem::query();

        // Búsqueda por nombre o descripción
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        // Filtro por tipo
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filtro por rareza
        if ($request->filled('rarity')) {
            $query->where('rarity', $request->rarity);
        }

        // Filtro por estado
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'stock':
                    $query->where('stock', '>', 0);
                    break;
                case 'out':
                    $query->where('stock', 0);
                    break;
                case 'active':
                    $query->where('is_active', 1);
                    break;
                case 'inactive':
                    $query->where('is_active', 0);
                    break;
            }
        }

        // Ordenamiento
        switch ($request->get('sort', 'recent')) {
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'stock':
                $query->orderBy('stock', 'desc');
                break;
            case 'sales':
                $query->orderBy('sales_count', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        // Paginación
        $items = $query->paginate(10)->withQueryString();

        // Filtros dinámicos
        $types = MarketItem::distinct()->pluck('type')->sort()->values();
        $rarities = ['común', 'poco común', 'raro', 'épico', 'legendario'];

        return view('admin.items.index', compact('items', 'types', 'rarities'));
    }

    public function create()
    {
        return view('admin.items.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'rarity' => 'required|string',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('market_items', 'public');
        }

        MarketItem::create([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'rarity' => $request->rarity,
            'stock' => $request->stock,
            'image' => $imagePath,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.items.index')
            ->with('success', 'Ítem creado exitosamente.');
    }

    public function show(MarketItem $item)
    {
        return view('admin.items.show', compact('item'));
    }

    public function edit(MarketItem $item)
    {
        return view('admin.items.edit', compact('item'));
    }

    public function update(Request $request, MarketItem $item)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'rarity' => 'required|string',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        $imagePath = $item->image;

        if ($request->hasFile('image')) {
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }

            $imagePath = $request->file('image')->store('market_items', 'public');
        }

        $item->update([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'rarity' => $request->rarity,
            'stock' => $request->stock,
            'image' => $imagePath,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.items.index')
            ->with('success', 'Ítem actualizado exitosamente.');
    }

    public function destroy(MarketItem $item)
    {
        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return redirect()->route('admin.items.index')
            ->with('success', 'Ítem eliminado exitosamente.');
    }
}
