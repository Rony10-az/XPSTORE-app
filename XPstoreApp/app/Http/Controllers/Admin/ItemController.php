<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::query();

        // Búsqueda por nombre
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        // Filtrar por tipo
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filtrar por rareza
        if ($request->filled('rarity')) {
            $query->where('rarity', $request->rarity);
        }

        // Filtrar por estado
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'stock':
                    $query->where('stock', '>', 0);
                    break;
                case 'out':
                    $query->where('stock', '=', 0);
                    break;
                case 'active':
                    $query->where('is_active', true);
                    break;
                case 'inactive':
                    $query->where('is_active', false);
                    break;
            }
        }

        // Ordenamiento
        $sort = $request->get('sort', 'recent');
        switch ($sort) {
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

        $items = $query->paginate(10)->withQueryString();

        // Obtener listas únicas para filtros
        $types = Item::distinct()->pluck('type')->sort()->values();
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
            'rarity' => 'required|in:común,poco común,raro,épico,legendario',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'nullable|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('items', 'public');
        }

        Item::create([
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

    public function show(Item $item)
    {
        return view('admin.items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        return view('admin.items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'rarity' => 'required|in:común,poco común,raro,épico,legendario',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'nullable|string',
        ]);

        $imagePath = $item->image;
        if ($request->hasFile('image')) {
            // Eliminar imagen antigua
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }

            // Subir nueva imagen
            $imagePath = $request->file('image')->store('items', 'public');
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

    public function destroy(Item $item)
    {
        // Eliminar imagen
        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return redirect()->route('admin.items.index')
            ->with('success', 'Ítem eliminado exitosamente.');
    }
}
