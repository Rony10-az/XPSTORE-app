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
        $codes = GameCode::with('videoGame');

        $search = $request->input('search', '');
        if ($search) {
            $codes->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhereHas('videoGame', function ($game) use ($search) {
                        $game->where('title', 'like', "%{$search}%");
                    });
            });
        }

        $status = $request->input('status', '');
        if ($status === 'used') {
            $codes->where('used', true);
        } elseif ($status === 'available') {
            $codes->where('used', false);
        }

        // Filtrar por videojuego si se pasa
        $videojuego = null;
        if ($request->video_game_id) {
            $videojuego = VideoGame::findOrFail($request->video_game_id);
            $codes->where('video_game_id', $videojuego->id);
        }

        $codes = $codes->orderByDesc('id')->paginate(10)->withQueryString();

        $metrics = [
            'total' => GameCode::count(),
            'used' => GameCode::where('used', true)->count(),
            'available' => GameCode::where('used', false)->count(),
        ];

        $videoGames = VideoGame::orderBy('title')->get(['id', 'title']);

        return view('admin.gamecodes.index', compact('codes', 'videojuego', 'metrics', 'videoGames', 'search', 'status'));
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
            'code' => 'nullable|string|unique:game_codes,code',
        ]);

        $videojuego = VideoGame::findOrFail($request->video_game_id);

        // Si el usuario envía un código manual, solo creamos uno
        if ($request->filled('code')) {
            GameCode::create([
                'video_game_id' => $videojuego->id,
                'code' => strtoupper($request->code),
            ]);
            $created = 1;
        } else {
            for ($i = 0; $i < $request->quantity; $i++) {
                GameCode::create([
                    'video_game_id' => $videojuego->id,
                    'code' => strtoupper(Str::random(12)),
                ]);
            }
            $created = $request->quantity;
        }

        return redirect()->route('admin.gamecodes.index')
            ->with('success', "{$created} código(s) generados para {$videojuego->title}.");
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
