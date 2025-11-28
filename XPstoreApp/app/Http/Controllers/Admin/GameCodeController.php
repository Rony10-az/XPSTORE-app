<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GameCode;
use App\Models\VideoGame;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GameCodeController extends Controller
{
    // Listar códigos con filtros avanzados
    public function index(Request $request)
    {
        $query = GameCode::with(['videoGame', 'user']);

        // Búsqueda por código
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('batch', 'like', "%{$search}%")
                    ->orWhereHas('videoGame', function ($game) use ($search) {
                        $game->where('title', 'like', "%{$search}%");
                    });
            });
        }

        // Filtrar por videojuego
        if ($request->filled('video_game_id')) {
            $query->where('video_game_id', $request->video_game_id);
        }

        // Filtrar por estado
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtrar por lote
        if ($request->filled('batch')) {
            $query->where('batch', $request->batch);
        }

        // Ordenamiento
        $sort = $request->get('sort', 'recent');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'code':
                $query->orderBy('code', 'asc');
                break;
            case 'game':
                $query->join('video_games', 'game_codes.video_game_id', '=', 'video_games.id')
                      ->orderBy('video_games.title', 'asc')
                      ->select('game_codes.*');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $codes = $query->paginate(15)->withQueryString();

        // Métricas
        $metrics = [
            'total' => GameCode::count(),
            'disponibles' => GameCode::where('status', 'disponible')->count(),
            'usados' => GameCode::where('status', 'usado')->count(),
            'vencidos' => GameCode::where('status', 'vencido')->count(),
        ];

        // Obtener videojuegos y lotes para filtros
        $videoGames = VideoGame::orderBy('title')->get(['id', 'title']);
        $batches = GameCode::whereNotNull('batch')->distinct()->pluck('batch')->sort()->values();

        return view('admin.gamecodes.index', compact('codes', 'metrics', 'videoGames', 'batches'));
    }

    // Formulario para crear códigos
    public function create()
    {
        $videoGames = VideoGame::orderBy('title')->get();
        return view('admin.gamecodes.create', compact('videoGames'));
    }

    // Guardar nuevos códigos (uno o lote)
    public function store(Request $request)
    {
        $request->validate([
            'video_game_id' => 'required|exists:video_games,id',
            'generation_mode' => 'required|in:single,batch',
            'code' => 'required_if:generation_mode,single|nullable|string|unique:game_codes,code',
            'quantity' => 'required_if:generation_mode,batch|nullable|integer|min:1|max:500',
            'batch_name' => 'nullable|string|max:255',
        ]);

        $videojuego = VideoGame::findOrFail($request->video_game_id);
        $created = 0;

        if ($request->generation_mode === 'single') {
            // Generar un solo código manual o automático
            $code = $request->filled('code') ? strtoupper($request->code) : GameCode::generateUniqueCode();

            GameCode::create([
                'video_game_id' => $videojuego->id,
                'code' => $code,
                'status' => 'disponible',
                'batch' => $request->batch_name,
            ]);
            $created = 1;
        } else {
            // Generar lote de códigos
            $batchName = $request->batch_name ?: 'LOTE-' . strtoupper(Str::random(8));

            for ($i = 0; $i < $request->quantity; $i++) {
                GameCode::create([
                    'video_game_id' => $videojuego->id,
                    'code' => GameCode::generateUniqueCode(),
                    'status' => 'disponible',
                    'batch' => $batchName,
                ]);
            }
            $created = $request->quantity;
        }

        return redirect()->route('admin.gamecodes.index')
            ->with('success', "{$created} código(s) generado(s) para {$videojuego->title}.");
    }

    // Ver detalles del código
    public function show(GameCode $gamecode)
    {
        $gamecode->load(['videoGame', 'user']);
        return view('admin.gamecodes.show', compact('gamecode'));
    }

    // Formulario para editar código
    public function edit(GameCode $gamecode)
    {
        $videoGames = VideoGame::orderBy('title')->get();
        return view('admin.gamecodes.edit', compact('gamecode', 'videoGames'));
    }

    // Actualizar código
    public function update(Request $request, GameCode $gamecode)
    {
        $request->validate([
            'video_game_id' => 'required|exists:video_games,id',
            'code' => 'required|string|unique:game_codes,code,' . $gamecode->id,
            'status' => 'required|in:disponible,usado,vencido',
            'batch' => 'nullable|string|max:255',
        ]);

        $gamecode->update($request->only('video_game_id', 'code', 'status', 'batch'));

        return redirect()->route('admin.gamecodes.index')
            ->with('success', "Código {$gamecode->code} actualizado.");
    }

    // Marcar código como usado
    public function markAsUsed(GameCode $gamecode)
    {
        if ($gamecode->status === 'usado') {
            return back()->with('error', 'El código ya está marcado como usado.');
        }

        $gamecode->markAsUsed();

        return back()->with('success', "Código {$gamecode->code} marcado como usado.");
    }

    // Marcar código como vencido
    public function markAsExpired(GameCode $gamecode)
    {
        $gamecode->markAsExpired();

        return back()->with('success', "Código {$gamecode->code} marcado como vencido.");
    }

    // Eliminar código
    public function destroy(GameCode $gamecode)
    {
        $code = $gamecode->code;
        $gamecode->delete();

        return redirect()->route('admin.gamecodes.index')
            ->with('success', "Código {$code} eliminado.");
    }

    // Eliminar lote completo
    public function destroyBatch(Request $request)
    {
        $request->validate([
            'batch' => 'required|string',
        ]);

        $count = GameCode::where('batch', $request->batch)->delete();

        return back()->with('success', "Lote '{$request->batch}' eliminado ({$count} códigos).");
    }
}
