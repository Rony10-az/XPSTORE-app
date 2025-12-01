<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MarketItem;
use App\Models\VideoGame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = MarketItem::with('game');

        // Búsqueda por nombre o descripción
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
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
        $videoGames = VideoGame::select('id', 'title')->orderBy('title')->get();
        return view('admin.items.create', compact('videoGames'));
    }

    public function store(Request $request)
    {
        // Aceptar tanto "title" como "name" desde el formulario
        $request->merge([
            'title' => $request->input('title') ?? $request->input('name'),
        ]);

        $request->validate([
            'title' => 'required|string|max:255',
            'video_game_id' => 'required|exists:video_games,id',
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
            'title' => $request->title,
            'video_game_id' => $request->video_game_id,
            'type' => $this->mapType($request->type),
            'price' => $request->price,
            'rarity' => $this->mapRarity($request->rarity),
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
        $videoGames = VideoGame::select('id', 'title')->orderBy('title')->get();
        return view('admin.items.edit', compact('item', 'videoGames'));
    }

    public function update(Request $request, MarketItem $item)
    {
        // Aceptar tanto "title" como "name" desde el formulario
        $request->merge([
            'title' => $request->input('title') ?? $request->input('name'),
        ]);

        $request->validate([
            'title' => 'required|string|max:255',
            'video_game_id' => 'required|exists:video_games,id',
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
            'title' => $request->title,
            'video_game_id' => $request->video_game_id,
            'type' => $this->mapType($request->type, $item->type),
            'price' => $request->price,
            'rarity' => $this->mapRarity($request->rarity, $item->rarity),
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

    /**
     * Normaliza el tipo a los valores permitidos por la base de datos.
     */
    private function mapType(string $input, ?string $fallback = 'item'): string
    {
        $map = [
            'skin' => 'skin',
            'weapon' => 'weapon',
            'arma' => 'weapon',
            'item' => 'item',
            'bundle' => 'bundle',
            'paquete' => 'bundle',
        ];

        $key = strtolower(trim($input));
        return $map[$key] ?? ($fallback ?? 'item');
    }

    /**
     * Normaliza la rareza a los valores permitidos por la base de datos.
     */
    private function mapRarity(string $input, ?string $fallback = 'common'): string
    {
        $map = [
            'common' => 'common',
            'comun' => 'common',
            'común' => 'common',
            'poco comun' => 'rare',
            'poco común' => 'rare',
            'rare' => 'rare',
            'raro' => 'rare',
            'epic' => 'epic',
            'epico' => 'epic',
            'épico' => 'epic',
            'legendary' => 'legendary',
            'legendario' => 'legendary',
        ];

        $key = strtolower(trim($input));
        return $map[$key] ?? ($fallback ?? 'common');
    }
}
