<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\GameCode;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $rating = $request->input('rating');
        $sort = $request->input('sort', 'recent');

        $query = Review::with(['user', 'videoGame']);

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
            'total' => Review::count(),
            'avg_rating' => round((float) Review::avg('rating'), 1),
            'low_ratings' => Review::where('rating', '<=', 2)->count(),
            'most_helpful' => Review::orderByDesc('helpful')->first(),
        ];

        return view('admin.reviews.index', compact('reviews', 'search', 'rating', 'sort', 'metrics'));
    }

    public function destroy(Review $review)
    {
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
}
