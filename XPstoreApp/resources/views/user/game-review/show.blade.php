@extends('layouts.app')

@section('title', $game->title)

@push('styles')
@vite('resources/css/store/show.css')
<style>
    .review-section {
        background: #1a1d29;
        border-radius: 12px;
        padding: 30px;
        margin-top: 30px;
    }

    .review-form {
        background: #252a3a;
        padding: 25px;
        border-radius: 8px;
        margin-bottom: 30px;
    }

    .review-form h3 {
        color: #fff;
        margin-bottom: 20px;
        font-size: 1.3rem;
    }

    .rating-input {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        flex-direction: row-reverse;
        justify-content: flex-end;
    }

    .rating-input input[type="radio"] {
        display: none;
    }

    .rating-input label {
        font-size: 2rem;
        color: #444;
        cursor: pointer;
        transition: color 0.2s;
    }

    .rating-input input:checked~label,
    .rating-input label:hover,
    .rating-input label:hover~label {
        color: #ffc107;
    }

    .review-textarea {
        width: 100%;
        min-height: 120px;
        background: #1a1d29;
        border: 1px solid #363b4e;
        border-radius: 8px;
        padding: 15px;
        color: #fff;
        font-family: inherit;
        font-size: 0.95rem;
        resize: vertical;
        margin-bottom: 15px;
    }

    .review-textarea:focus {
        outline: none;
        border-color: #6c63ff;
    }

    .btn-submit-review {
        background: linear-gradient(135deg, #6c63ff, #5a52d5);
        color: white;
        padding: 12px 30px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .btn-submit-review:hover {
        transform: translateY(-2px);
    }

    .reviews-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .review-card {
        background: #252a3a;
        padding: 20px;
        border-radius: 8px;
        border-left: 4px solid #6c63ff;
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .review-user {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .review-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
    }

    .review-user-info h4 {
        color: #fff;
        margin: 0;
        font-size: 1rem;
    }

    .review-date {
        color: #888;
        font-size: 0.85rem;
    }

    .review-rating {
        color: #ffc107;
        font-size: 1.1rem;
    }

    .review-comment {
        color: #ccc;
        line-height: 1.6;
        margin-bottom: 10px;
    }

    .verified-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #28a745;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .alert-success {
        background: #28a745;
        color: white;
    }

    .alert-error {
        background: #dc3545;
        color: white;
    }

    .alert-info {
        background: #17a2b8;
        color: white;
    }

    .no-reviews {
        text-align: center;
        padding: 40px;
        color: #888;
    }

    .edit-delete-actions {
        display: flex;
        gap: 10px;
        margin-top: 10px;
    }

    .btn-edit,
    .btn-delete {
        padding: 6px 15px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        font-size: 0.85rem;
        transition: all 0.2s;
    }

    .btn-edit {
        background: #ffc107;
        color: #000;
    }

    .btn-delete {
        background: #dc3545;
        color: white;
    }
</style>
@endpush

@section('content')

<div class="show-wrapper">

    {{-- Volver --}}
    <div class="back-button">
        <a href="{{ route('library.index') }}">
            <i class="fas fa-arrow-left"></i> Volver a mi biblioteca
        </a>
    </div>

    <section class="hero-row">

        {{-- HERO IZQUIERDA --}}
        <div class="hero-left">

            <div class="hero-card">

                <div class="hero-badges">
                    @if ($game->discount > 0)
                    <span class="badge badge-discount">-{{ $game->discount }}%</span>
                    @endif

                    <span class="badge badge-top">
                        <i class="fas fa-award"></i> Top Rated
                    </span>
                </div>

                <div class="hero-main">
                    <img id="heroMainImage" src="{{ $game->images[0] }}" alt="">
                </div>

                <div class="hero-indicators">
                    @foreach ($game->images as $i => $img)
                    <span class="indicator {{ $i == 0 ? 'active' : '' }}" data-index="{{ $i }}"></span>
                    @endforeach
                </div>

            </div>

            <div class="hero-thumbnails">
                @foreach ($game->images as $i => $img)
                <div class="hero-thumb {{ $i == 0 ? 'active' : '' }}" data-img="{{ $img }}" data-index="{{ $i }}">
                    <img src="{{ $img }}">
                </div>
                @endforeach
            </div>

        </div>


        {{-- PANEL DERECHO --}}
        <div class="hero-right">

            <h2 class="game-title">{{ $game->title }}</h2>

            <div class="rating">
                <i class="fas fa-star"></i> {{ number_format($game->rating, 1) }}
                <span class="reviews">({{ $game->reviews->count() }} reseñas)</span>
            </div>

            <div class="platform-tags">
                @foreach($game->genre as $g)
                <span class="tag">{{ $g }}</span>
                @endforeach
            </div>

            <div class="price-section">

                @if($game->discount > 0)
                <div class="price-top">
                    <span class="discount-tag">-{{ $game->discount }}%</span>
                    <span class="old-price">S/. {{ number_format($game->price, 2) }}</span>
                </div>
                @endif

                <div class="new-price">S/. {{ number_format($game->price_after_discount, 2) }}</div>

            </div>

            @if($hasPurchased)
            <div class="verified-badge">
                <i class="fas fa-check-circle"></i> Ya compraste este juego
            </div>
            @endif

            <ul class="benefits">
                <li><i class="fas fa-bolt"></i> Entrega instantánea</li>
                <li><i class="fas fa-box"></i> Stock garantizado</li>
                <li><i class="fas fa-headset"></i> Soporte 24/7</li>
                <li><i class="fas fa-undo"></i> Garantía de devolución</li>
            </ul>

        </div>

    </section>

    {{-- SECCIÓN DE RESEÑAS --}}
    <section class="review-section">
        <h2 style="color: white; margin-bottom: 25px;">
            <i class="fas fa-comments"></i> Reseñas del juego
        </h2>

        @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
        @endif

        {{-- MIS RESEÑAS (Aprobadas, Rechazadas, Pendientes) --}}
        @if($userReviews->count() > 0)
        <div style="margin-bottom: 30px;">
            <h3 style="color: white; margin-bottom: 20px;">
                <i class="fas fa-user-edit"></i> Mis reseñas de este juego
            </h3>

            @foreach($userReviews as $myReview)
            <div class="my-review-card" style="
                background: {{ $myReview->status === 'rechazada' ? '#2a1a1a' : ($myReview->status === 'pendiente' ? '#2a2a1a' : '#1a2a1a') }};
                border-left: 4px solid {{ $myReview->status === 'rechazada' ? '#dc3545' : ($myReview->status === 'pendiente' ? '#ffc107' : '#28a745') }};
                padding: 20px;
                border-radius: 8px;
                margin-bottom: 15px;
            ">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <div>
                        <span style="color: #ccc; font-size: 0.9rem;">
                            <i class="far fa-clock"></i> {{ $myReview->created_at->format('d/m/Y H:i') }}
                        </span>
                    </div>
                    <div>
                        @if($myReview->status === 'aprobada')
                            <span class="badge badge-success">
                                <i class="fas fa-check-circle"></i> Aprobada
                            </span>
                        @elseif($myReview->status === 'rechazada')
                            <span class="badge badge-danger">
                                <i class="fas fa-times-circle"></i> Rechazada
                            </span>
                        @else
                            <span class="badge badge-warning">
                                <i class="fas fa-clock"></i> En revisión
                            </span>
                        @endif
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <div class="review-rating" style="color: #ffc107; margin-bottom: 10px;">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $myReview->rating)
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                        <strong style="color: white; margin-left: 10px;">({{ $myReview->rating }}/5)</strong>
                    </div>
                    <p class="review-comment" style="color: #ddd; line-height: 1.6;">
                        {{ $myReview->comment }}
                    </p>
                </div>

                @if($myReview->status === 'rechazada')
                <div style="
                    background: rgba(220, 53, 69, 0.1);
                    border: 1px solid rgba(220, 53, 69, 0.3);
                    border-radius: 8px;
                    padding: 15px;
                    margin-top: 15px;
                ">
                    <h4 style="color: #ff6b6b; margin: 0 0 10px 0; font-size: 1rem;">
                        <i class="fas fa-exclamation-triangle"></i> Motivo del rechazo
                    </h4>

                    <div style="color: #ffb3b3; margin-bottom: 10px;">
                        <strong>Razón:</strong>
                        {{ \App\Models\GameReview::getRejectionReasons()[$myReview->rejection_reason] ?? 'No especificado' }}
                    </div>

                    @if($myReview->moderation_note)
                    <div style="color: #ffb3b3; margin-bottom: 10px;">
                        <strong>Nota del moderador:</strong><br>
                        <em>"{{ $myReview->moderation_note }}"</em>
                    </div>
                    @endif

                    @if($myReview->moderator)
                    <div style="color: #999; font-size: 0.85rem; margin-top: 10px;">
                        <i class="fas fa-user-shield"></i> Moderado por: {{ $myReview->moderator->name }}
                        @if($myReview->moderated_at)
                            el {{ $myReview->moderated_at->format('d/m/Y') }} a las {{ $myReview->moderated_at->format('H:i') }}
                        @endif
                    </div>
                    @endif
                </div>
                @endif

                @if($myReview->status === 'pendiente')
                <div style="
                    background: rgba(255, 193, 7, 0.1);
                    border: 1px solid rgba(255, 193, 7, 0.3);
                    border-radius: 8px;
                    padding: 15px;
                    margin-top: 15px;
                ">
                    <p style="color: #ffcc00; margin: 0;">
                        <i class="fas fa-info-circle"></i>
                        Tu reseña está siendo revisada por nuestro equipo de moderación.
                    </p>
                </div>
                @endif

                <div style="margin-top: 15px;">
                    <form action="{{ route('library.game.review.destroy', $myReview->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta reseña?')" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete" style="
                            background: #dc3545;
                            color: white;
                            padding: 8px 15px;
                            border: none;
                            border-radius: 6px;
                            cursor: pointer;
                            font-size: 0.9rem;
                        ">
                            <i class="fas fa-trash"></i> Eliminar mi reseña
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        @if($hasPurchased)
        {{-- FORMULARIO DE RESEÑA --}}
        <div class="review-form">
            <h3>
                <i class="fas fa-pen"></i> Deja una nueva reseña
            </h3>

            <form action="{{ route('library.game.review.store', $game->id) }}" method="POST">
                @csrf

                <label style="color: #ccc; display: block; margin-bottom: 10px;">Calificación</label>
                <div class="rating-input">
                    <input type="radio" name="rating" id="star5" value="5" required>
                    <label for="star5"><i class="fas fa-star"></i></label>

                    <input type="radio" name="rating" id="star4" value="4">
                    <label for="star4"><i class="fas fa-star"></i></label>

                    <input type="radio" name="rating" id="star3" value="3">
                    <label for="star3"><i class="fas fa-star"></i></label>

                    <input type="radio" name="rating" id="star2" value="2">
                    <label for="star2"><i class="fas fa-star"></i></label>

                    <input type="radio" name="rating" id="star1" value="1">
                    <label for="star1"><i class="fas fa-star"></i></label>
                </div>

                <label style="color: #ccc; display: block; margin-bottom: 10px;">Tu opinión</label>
                <textarea name="comment" class="review-textarea" placeholder="Cuéntanos qué te pareció el juego..." required></textarea>

                <button type="submit" class="btn-submit-review">
                    <i class="fas fa-paper-plane"></i>
                    Publicar reseña
                </button>
            </form>
        </div>
        @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Debes comprar este juego para dejar una reseña
        </div>
        @endif

        {{-- LISTA DE RESEÑAS --}}
        <h3 style="color: white; margin-bottom: 20px; margin-top: 30px;">
            Todas las reseñas ({{ $game->reviews->count() }})
        </h3>

        @if($game->reviews->count() > 0)
        <div class="reviews-list">
            @foreach($game->reviews as $review)
            <div class="review-card">
                <div class="review-header">
                    <div class="review-user">
                        <img src="{{ $review->user->avatar ? asset('storage/' . $review->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($review->user->name) }}"
                            alt="{{ $review->user->name }}"
                            class="review-avatar">
                        <div class="review-user-info">
                            <h4>{{ $review->user->name }}</h4>
                            <span class="review-date">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <div class="review-rating">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <=$review->rating)
                            <i class="fas fa-star"></i>
                            @else
                            <i class="far fa-star"></i>
                            @endif
                            @endfor
                    </div>
                </div>

                <p class="review-comment">{{ $review->comment }}</p>

                @if($review->is_verified_purchase)
                <span class="verified-badge">
                    <i class="fas fa-check-circle"></i> Compra verificada
                </span>
                @endif

                @if($review->user_id == Auth::id())
                <div class="edit-delete-actions">
                    <form action="{{ route('library.game.review.destroy', $review->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar tu reseña?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </form>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <div class="no-reviews">
            <i class="far fa-comment" style="font-size: 3rem; margin-bottom: 15px;"></i>
            <p>Aún no hay reseñas para este juego</p>
            <small>Sé el primero en dejar tu opinión</small>
        </div>
        @endif

    </section>

</div>

{{-- SCRIPTS --}}
<script>
    // Switch thumbnails
    document.querySelectorAll(".hero-thumb").forEach(t => {
        t.addEventListener("click", () => {
            document.getElementById("heroMainImage").src = t.dataset.img;

            document.querySelector(".hero-thumb.active")?.classList.remove("active");
            t.classList.add("active");
        });
    });
</script>

@endsection
