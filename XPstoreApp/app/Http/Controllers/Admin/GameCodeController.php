<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GameCode;
use App\Models\VideoGame;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GameCodeController extends Controller
{
    // Listar códigos
    public function index(Request $request)
    {
        $codes = GameCode::query();

        // Filtrar por videojuego si se pasa
        $videojuego = null;
        if ($request->video_game_id) {
            $videojuego = VideoGame::findOrFail($request->video_game_id);
            $codes->where('video_game_id', $videojuego->id);
        }

        $codes = $codes->paginate(10);

        return view('admin.gamecodes.index', compact('codes', 'videojuego'));
    }

    // Formulario para crear un nuevo código
    public function create()
    {
        $videoGames = VideoGame::all();
        return view('admin.gamecodes.create', compact('videoGames'));
    }

    // Guardar nuevos códigos
    public function store(Request $request)
    {
        $request->validate([
            'video_game_id' => 'required|exists:video_games,id',
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        $videojuego = VideoGame::findOrFail($request->video_game_id);

        for ($i = 0; $i < $request->quantity; $i++) {
            GameCode::create([
                'video_game_id' => $videojuego->id,
                'code' => strtoupper(Str::random(12)),
            ]);
        }

        return redirect()->route('admin.gamecodes.index')
            ->with('success', "{$request->quantity} códigos generados para {$videojuego->title}.");
    }
    public function edit(GameCode $gamecode)
    {
        $videoGames = VideoGame::all();
        return view('admin.gamecodes.edit', compact('gamecode', 'videoGames'));
    }

    public function update(Request $request, GameCode $gamecode)
    {
        $request->validate([
            'video_game_id' => 'required|exists:video_games,id',
            'code' => 'required|string|unique:game_codes,code,' . $gamecode->id,
            'used' => 'sometimes|boolean',
        ]);

        $gamecode->update($request->only('video_game_id', 'code', 'used'));

        return redirect()->route('admin.gamecodes.index')
            ->with('success', "Código {$gamecode->code} actualizado correctamente.");
    }

    public function show(GameCode $gamecode)
    {
        return view('admin.gamecodes.show', compact('gamecode'));
    }


    // Eliminar código
    public function destroy(GameCode $gamecode)
    {
        $gamecode->delete();
        return back()->with('success', "Código {$gamecode->code} eliminado.");
    }
}
