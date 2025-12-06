<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\GameReview;
use App\Models\ReviewModerationHistory;
use App\Models\GameCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $statusFilter = $request->input('status', ''); // Filtro por estado

        // Obtener usuarios con sus reseñas agrupadas
        $usersQuery = User::whereHas('gameReviews', function($query) use ($statusFilter) {
                if ($statusFilter) {
                    $query->where('status', $statusFilter);
                }
            })
            ->withCount(['gameReviews' => function($query) use ($statusFilter) {
                if ($statusFilter) {
                    $query->where('status', $statusFilter);
                }
            }])
            ->with(['gameReviews' => function($query) use ($statusFilter) {
                $query->with('videoGame')->orderBy('created_at', 'desc');
                if ($statusFilter) {
                    $query->where('status', $statusFilter);
                }
            }]);

        if ($search) {
            $usersQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $usersQuery->orderByDesc('game_reviews_count')->paginate(10)->withQueryString();

        // Métricas
        $totalUsers = User::count();
        $usersWithReviews = GameReview::distinct('user_id')->count('user_id');

        $metrics = [
            'total' => GameReview::count(),
            'avg_rating' => round((float) GameReview::avg('rating'), 1),
            'low_ratings' => GameReview::where('rating', '<=', 2)->count(),
            'verified_purchases' => GameReview::where('is_verified_purchase', true)->count(),
            'total_users' => $totalUsers,
            'users_with_reviews' => $usersWithReviews,
        ];

        return view('admin.reviews.index', compact('users', 'search', 'metrics', 'statusFilter'));
    }

    public function destroy($id)
    {
        $review = GameReview::findOrFail($id);
        $review->delete();

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Reseña eliminada correctamente.');
    }

    public function verifiedBuyers(Request $request)
    {
        $search = $request->input('search', '');
        $rating = $request->input('rating');
        $sort = $request->input('sort', 'recent');

        // Obtener IDs de usuarios que han comprado juegos (tienen códigos asignados)
        $buyerIds = GameCode::whereNotNull('user_id')
            ->distinct()
            ->pluck('user_id');

        // Filtrar reseñas solo de compradores verificados
        $query = Review::with(['user', 'videoGame'])
            ->whereIn('user_id', $buyerIds);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('videoGame', function ($gameQuery) use ($search) {
                        $gameQuery->where('title', 'like', "%{$search}%");
                    });
            });
        }

        if ($rating) {
            $query->where('rating', $rating);
        }

        $query->when($sort === 'helpful', function ($q) {
            $q->orderByDesc('helpful');
        }, function ($q) use ($sort) {
            if ($sort === 'high_rating') {
                $q->orderByDesc('rating');
            } else {
                $q->orderByDesc('created_at');
            }
        });

        $reviews = $query->paginate(10)->withQueryString();

        $metrics = [
            'total' => Review::whereIn('user_id', $buyerIds)->count(),
            'avg_rating' => round((float) Review::whereIn('user_id', $buyerIds)->avg('rating'), 1),
            'low_ratings' => Review::whereIn('user_id', $buyerIds)->where('rating', '<=', 2)->count(),
            'most_helpful' => Review::whereIn('user_id', $buyerIds)->orderByDesc('helpful')->first(),
        ];

        return view('admin.reviews.verified', compact('reviews', 'search', 'rating', 'sort', 'metrics'));
    }

    public function updateSentiment(Request $request, Review $review)
    {
        $request->validate([
            'sentiment' => 'required|in:bueno,medio,malo',
        ]);

        $review->update([
            'sentiment' => $request->sentiment,
            'moderated_at' => now(),
            'moderated_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Sentimiento actualizado correctamente.');
    }

    public function addWarning(Request $request, Review $review)
    {
        $request->validate([
            'warning_message' => 'required|string|max:500',
        ]);

        $review->update([
            'warning_message' => $request->warning_message,
            'moderated_at' => now(),
            'moderated_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Advertencia agregada correctamente.');
    }

    public function toggleBlock(Review $review)
    {
        $review->update([
            'is_blocked' => !$review->is_blocked,
            'moderated_at' => now(),
            'moderated_by' => auth()->id(),
        ]);

        $message = $review->is_blocked ? 'Comentario bloqueado correctamente.' : 'Comentario desbloqueado correctamente.';

        return redirect()->back()->with('success', $message);
    }

    // ===================================
    // NUEVAS ACCIONES DE MODERACIÓN
    // ===================================

    /**
     * Mostrar todas las reseñas de un usuario
     */
    public function showUserReviews($userId)
    {
        $user = User::with(['gameReviews' => function($query) {
            $query->with(['videoGame', 'moderator'])->orderBy('created_at', 'desc');
        }])->findOrFail($userId);

        return view('admin.reviews.user-reviews', compact('user'));
    }

    /**
     * Mostrar detalles de una reseña con historial
     */
    public function show($id)
    {
        $review = GameReview::with(['user', 'videoGame', 'moderator', 'moderationHistory.admin'])
            ->findOrFail($id);

        return view('admin.reviews.show', compact('review'));
    }

    /**
     * Aprobar una reseña
     */
    public function approve($id)
    {
        $review = GameReview::findOrFail($id);
        $previousStatus = $review->status;

        $review->update([
            'status' => 'aprobada',
            'rejection_reason' => null,
            'moderated_at' => now(),
            'moderated_by' => Auth::id()
        ]);

        // Registrar en el historial
        ReviewModerationHistory::create([
            'game_review_id' => $review->id,
            'admin_id' => Auth::id(),
            'action' => 'aprobar',
            'previous_status' => $previousStatus,
            'new_status' => 'aprobada',
            'note' => 'Reseña aprobada por el administrador'
        ]);

        return redirect()->back()->with('success', 'Reseña aprobada correctamente');
    }

    /**
     * Rechazar una reseña
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|in:lenguaje_ofensivo,spam,contenido_no_relacionado,insultos,otro',
            'moderation_note' => 'nullable|string|max:500'
        ]);

        $review = GameReview::findOrFail($id);
        $previousStatus = $review->status;

        $review->update([
            'status' => 'rechazada',
            'rejection_reason' => $request->rejection_reason,
            'moderation_note' => $request->moderation_note,
            'moderated_at' => now(),
            'moderated_by' => Auth::id()
        ]);

        // Registrar en el historial
        ReviewModerationHistory::create([
            'game_review_id' => $review->id,
            'admin_id' => Auth::id(),
            'action' => 'rechazar',
            'previous_status' => $previousStatus,
            'new_status' => 'rechazada',
            'rejection_reason' => $request->rejection_reason,
            'note' => $request->moderation_note ?? 'Reseña rechazada'
        ]);

        return redirect()->back()->with('success', 'Reseña rechazada correctamente');
    }

    /**
     * Marcar una reseña como pendiente
     */
    public function pending($id)
    {
        $review = GameReview::findOrFail($id);
        $previousStatus = $review->status;

        $review->update([
            'status' => 'pendiente',
            'rejection_reason' => null,
            'moderation_note' => null,
            'moderated_at' => now(),
            'moderated_by' => Auth::id()
        ]);

        // Registrar en el historial
        ReviewModerationHistory::create([
            'game_review_id' => $review->id,
            'admin_id' => Auth::id(),
            'action' => 'marcar_pendiente',
            'previous_status' => $previousStatus,
            'new_status' => 'pendiente',
            'note' => 'Reseña marcada como pendiente por el administrador'
        ]);

        return redirect()->back()->with('success', 'Reseña marcada como pendiente correctamente');
    }

    /**
     * Ocultar una reseña (sin eliminarla)
     */
    public function hide(Request $request, $id)
    {
        $request->validate([
            'moderation_note' => 'nullable|string|max:500'
        ]);

        $review = GameReview::findOrFail($id);
        $previousStatus = $review->status;

        $review->update([
            'status' => 'rechazada',
            'moderation_note' => $request->moderation_note ?? 'Reseña ocultada',
            'moderated_at' => now(),
            'moderated_by' => Auth::id()
        ]);

        // Registrar en el historial
        ReviewModerationHistory::create([
            'game_review_id' => $review->id,
            'admin_id' => Auth::id(),
            'action' => 'ocultar',
            'previous_status' => $previousStatus,
            'new_status' => 'rechazada',
            'note' => $request->moderation_note ?? 'Reseña ocultada'
        ]);

        return redirect()->back()->with('success', 'Reseña ocultada correctamente');
    }
}
