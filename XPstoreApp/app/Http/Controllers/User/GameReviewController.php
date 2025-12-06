<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\GameReview;
use App\Models\UserPurchase;
use App\Models\VideoGame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameReviewController extends Controller
{
    /**
     * Mostrar la vista de detalle del juego con reseñas
     */
    public function show($gameId)
    {
        $game = VideoGame::with(['reviews' => function($query) {
            $query->where('status', 'aprobada')->with('user');
        }])->findOrFail($gameId);

        // Verificar si el usuario compró este juego
        $hasPurchased = UserPurchase::where('user_id', Auth::id())
            ->where('video_game_id', $gameId)
            ->exists();

        // Obtener TODAS las reseñas del usuario para este juego (incluyendo rechazadas)
        $userReviews = GameReview::where('user_id', Auth::id())
            ->where('video_game_id', $gameId)
            ->with('moderator')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.game-review.show', compact('game', 'hasPurchased', 'userReviews'));
    }

    /**
     * Guardar una nueva reseña
     */
    public function store(Request $request, $gameId)
    {
        // Validar que el usuario haya comprado el juego
        $hasPurchased = UserPurchase::where('user_id', Auth::id())
            ->where('video_game_id', $gameId)
            ->exists();

        if (!$hasPurchased) {
            return redirect()->back()->with('error', 'Debes comprar este juego para dejar una reseña');
        }

        // Validar datos
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000'
        ]);

        // Crear nueva reseña (permitir múltiples reseñas)
        GameReview::create([
            'user_id' => Auth::id(),
            'video_game_id' => $gameId,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_verified_purchase' => true,
            'status' => 'aprobada'
        ]);

        return redirect()->back()->with('success', 'Tu reseña ha sido publicada correctamente');
    }

    /**
     * Actualizar una reseña existente
     */
    public function update(Request $request, $reviewId)
    {
        $review = GameReview::where('id', $reviewId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000'
        ]);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return redirect()->back()->with('success', 'Tu reseña ha sido actualizada');
    }

    /**
     * Eliminar una reseña
     */
    public function destroy($reviewId)
    {
        $review = GameReview::where('id', $reviewId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $review->delete();

        return redirect()->back()->with('success', 'Tu reseña ha sido eliminada');
    }
}
