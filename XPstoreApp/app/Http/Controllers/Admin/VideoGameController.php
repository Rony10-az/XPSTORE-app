<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoGame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoGameController extends Controller
{
    public function index()
    {
        $videojuegos = VideoGame::orderBy('id', 'desc')->paginate(10); // 10 items por página

        return view('admin.videojuegos.index', compact('videojuegos'));
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
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'genre' => 'required|array',
            'platform' => 'required|array',
            'release_date' => 'required|date',
            'developer' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'rating' => 'nullable|numeric|min:0|max:5',
            'stock' => 'required|integer|min:0',
            'featured' => 'boolean',
            'requirements' => 'nullable|array',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('videojuegos', 'public');
                $imagePaths[] = $path;
            }
        }

        VideoGame::create([
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
            'rating' => $request->rating ?? 0,
            'stock' => $request->stock,
            'featured' => $request->has('featured'),
            'requirements' => $request->requirements ?? [],
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
            'rating' => 'nullable|numeric|min:0|max:5',
            'stock' => 'required|integer|min:0',
            'featured' => 'boolean',
            'requirements' => 'nullable|array',
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
            'rating' => $request->rating ?? 0,
            'stock' => $request->stock,
            'featured' => $request->has('featured'),
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
