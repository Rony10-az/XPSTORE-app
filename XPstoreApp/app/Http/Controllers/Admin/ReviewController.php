<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
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
}
