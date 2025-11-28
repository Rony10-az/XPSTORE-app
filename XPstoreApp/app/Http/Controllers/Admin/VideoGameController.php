<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoGame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoGameController extends Controller
{
    public function index(Request $request)
    {
        $query = VideoGame::query();

        // Búsqueda por nombre
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('developer', 'like', "%{$search}%")
                  ->orWhere('publisher', 'like', "%{$search}%");
        }

        // Filtrar por plataforma
        if ($request->filled('platform')) {
            $query->whereJsonContains('platform', $request->platform);
        }

        // Filtrar por género
        if ($request->filled('genre')) {
            $query->whereJsonContains('genre', $request->genre);
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
                case 'featured':
                    $query->where('featured', true);
                    break;
                case 'discount':
                    $query->where('discount', '>', 0);
                    break;
            }
        }

        // Ordenamiento
        $sort = $request->get('sort', 'recent');
        switch ($sort) {
            case 'name':
                $query->orderBy('title', 'asc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'popularity':
                $query->orderBy('popularity', 'desc');
                break;
            case 'stock':
                $query->orderBy('stock', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $videojuegos = $query->paginate(10)->withQueryString();

        // Obtener listas únicas para filtros
        $platforms = VideoGame::whereNotNull('platform')->get()->pluck('platform')->flatten()->unique()->sort()->values();
        $genres = VideoGame::whereNotNull('genre')->get()->pluck('genre')->flatten()->unique()->sort()->values();

        return view('admin.videojuegos.index', compact('videojuegos', 'platforms', 'genres'));
    }

    public function create()
    {
        return view('admin.videojuegos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'genre' => 'required|array',
            'platform' => 'required|array',
            'release_date' => 'required|date',
            'developer' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'popularity' => 'nullable|integer|min:1|max:5',
            'stock' => 'required|integer|min:0',
            'featured' => 'boolean',
            'requirements' => 'nullable|string',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('videojuegos', 'public');
                $imagePaths[] = $path;
            }
        }
        $requirements = [];
        if ($request->requirements) {
        $requirements = json_decode($request->requirements, true) ?? [];
       }

        VideoGame::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'discount' => $request->discount ?? 0,
            'images' => !empty($imagePaths) ? $imagePaths : [],
            'genre' => $request->genre,
            'platform' => $request->platform,
            'release_date' => $request->release_date,
            'developer' => $request->developer,
            'publisher' => $request->publisher,
            'stock' => $request->stock,
            'featured' => $request->has('featured'),
            'popularity' => $request->popularity ?? 3,
            'requirements' => $requirements,
        ]);

        return redirect()->route('admin.videojuegos.index')
            ->with('success', 'Videojuego creado exitosamente.');
    }

    public function show(VideoGame $videojuego)
    {
        return view('admin.videojuegos.show', compact('videojuego'));
    }

    public function edit(VideoGame $videojuego)
    {
        return view('admin.videojuegos.edit', compact('videojuego'));
    }

    public function update(Request $request, VideoGame $videojuego)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'genre' => 'required|array',
            'platform' => 'required|array',
            'release_date' => 'required|date',
            'developer' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'popularity' => 'nullable|integer|min:1|max:5',
            'stock' => 'required|integer|min:0',
            'featured' => 'boolean',
            'requirements' => 'nullable|string',
        ]);

        $imagePaths = $videojuego->images ?? [];
        if ($request->hasFile('images')) {
            // Eliminar imágenes antiguas
            foreach ($videojuego->images as $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }

            // Subir nuevas imágenes
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('videojuegos', 'public');
                $imagePaths[] = $path;
            }
        }

        $videojuego->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'discount' => $request->discount ?? 0,
            'images' => $imagePaths,
            'genre' => $request->genre,
            'platform' => $request->platform,
            'release_date' => $request->release_date,
            'developer' => $request->developer,
            'publisher' => $request->publisher,
            'stock' => $request->stock,
            'featured' => $request->has('featured'),
            'popularity' => $request->popularity ?? 3,
            'requirements' => $request->requirements ?? [],
        ]);

        return redirect()->route('admin.videojuegos.index')
            ->with('success', 'Videojuego actualizado exitosamente.');
    }

    public function destroy(VideoGame $videojuego)
    {
        // Eliminar imágenes
        foreach ($videojuego->images as $image) {
            Storage::disk('public')->delete($image);
        }

        $videojuego->delete();

        return redirect()->route('admin.videojuegos.index')
            ->with('success', 'Videojuego eliminado exitosamente.');
    }
}
