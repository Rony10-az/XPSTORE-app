@extends('layouts.app')

@section('title', $game->title)

@push('styles')
@vite('resources/css/store/show.css')
@endpush

@section('content')

<div class="show-wrapper">

    {{-- 🔙 Volver --}}
    <div class="back-button">
        <a href="{{ route('dashboard.user') }}">
            <i class="fas fa-arrow-left"></i> Volver al catálogo
        </a>
    </div>
    <section class="hero-row">

        {{-- ========== HERO IZQUIERDA ========== --}}
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


        {{-- ========== PANEL DERECHO — ENEBA STYLE ========== --}}
        <div class="hero-right">

            <h2 class="game-title">{{ $game->title }}</h2>

            <div class="rating">
                <i class="fas fa-star"></i> {{ number_format($game->rating, 1) }}
                <span class="reviews">(0 reseñas)</span>
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
                    <span class="old-price">${{ number_format($game->price, 2) }}</span>
                </div>
                @endif

                <div class="new-price">${{ number_format($game->price_after_discount, 2) }}</div>

            </div>


            <button class="btn-buy">
                <i class="fas fa-shopping-cart"></i>
                Agregar al carrito
            </button>

            <button class="btn-wishlist">
                <i class="far fa-heart"></i>
                Favoritos
            </button>

            <button class="btn-wishlist">
                <i class="fas fa-share"></i>
                Compartir
            </button>

            <ul class="benefits">
                <li><i class="fas fa-bolt"></i> Entrega instantánea</li>
                <li><i class="fas fa-box"></i> Stock garantizado</li>
                <li><i class="fas fa-headset"></i> Soporte 24/7</li>
                <li><i class="fas fa-undo"></i> Garantía de devolución</li>
            </ul>

        </div>

    </section>




    {{-- =====================================================
         DETALLES (GRID)
    ====================================================== --}}
    <section class="game-details-grid">

        {{-- IZQUIERDA --}}
        <div class="details-left">

            {{-- QUick Stats --}}
            <div class="quick-stats">
                <div class="stat-box">
                    <i class="fas fa-chart-line"></i>
                    <span class="stat-label">Jugadores activos</span>
                    <span class="stat-value">125,000</span>
                </div>

                <div class="stat-box">
                    <i class="fas fa-clock"></i>
                    <span class="stat-label">Tiempo promedio</span>
                    <span class="stat-value">45 horas</span>
                </div>

                <div class="stat-box">
                    <i class="fas fa-trophy"></i>
                    <span class="stat-label">Logros</span>
                    <span class="stat-value">18/42</span>
                </div>

                <div class="stat-box">
                    <i class="fas fa-hdd"></i>
                    <span class="stat-label">Tamaño</span>
                    <span class="stat-value">85 GB</span>
                </div>
            </div>

            {{-- Features --}}
            <h2 class="section-title">Características del juego</h2>

            <div class="feature-grid">

                <div class="feature-box">
                    <i class="fas fa-users"></i>
                    Multijugador Online
                </div>

                <div class="feature-box">
                    <i class="fas fa-gamepad"></i>
                    Cooperativo Local
                </div>

                <div class="feature-box">
                    <i class="fas fa-trophy"></i>
                    42 Logros
                </div>

                <div class="feature-box">
                    <i class="fas fa-cloud"></i>
                    Guardado en la nube
                </div>

            </div>

            {{-- Tabs --}}
            <div class="tabs">
                <button class="tab active" data-tab="desc">Descripción</button>
                <button class="tab" data-tab="req">Requisitos</button>
                <button class="tab" data-tab="ach">Logros</button>
            </div>


            {{-- TAB: DESCRIPCIÓN --}}
            <div class="tab-content active" id="tab-desc">
                <h3 class="section-subtitle">Acerca del juego</h3>

                <p class="description">{{ $game->description }}</p>

                <div class="tech-grid">

                    <div class="tech-box">
                        <i class="fas fa-calendar"></i>
                        Lanzamiento
                        <br>
                        <span>{{ $game->release_date }}</span>
                    </div>

                    <div class="tech-box">
                        <i class="fas fa-globe"></i>
                        Idiomas
                        <br>
                        <span>Español, Inglés, Francés</span>
                    </div>

                    <div class="tech-box">
                        <i class="fas fa-code"></i>
                        Desarrollador
                        <br>
                        <span>{{ $game->developer }}</span>
                    </div>

                    <div class="tech-box">
                        <i class="fas fa-shield-alt"></i>
                        Clasificación
                        <br>
                        <span>PEGI 16</span>
                    </div>

                    <div class="tech-box">
                        <i class="fas fa-download"></i>
                        Tamaño
                        <br>
                        <span>85 GB</span>
                    </div>

                    <div class="tech-box">
                        <i class="fas fa-sync"></i>
                        Última actualización
                        <br>
                        <span>15 Oct 2024</span>
                    </div>

                </div>
            </div>

            {{-- TAB: REQUISITOS --}}
            <div class="tab-content" id="tab-req">
                <div class="requirements">

                    <div class="req-box">
                        <h3>Mínimos</h3>

                        <ul>
                            @foreach ($game->requirements['minimum'] ?? [] as $k => $v)
                            <li><strong>{{ $k }}:</strong> {{ $v }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="req-box">
                        <h3>Recomendados</h3>

                        <ul>
                            @foreach ($game->requirements['recommended'] ?? [] as $k => $v)
                            <li><strong>{{ $k }}:</strong> {{ $v }}</li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>

            {{-- TAB: LOGROS --}}
            <div class="tab-content" id="tab-ach">
                <p>Aquí irán los logros del juego…</p>
            </div>

        </div><!-- END LEFT -->

    </section><!--  ✔ CIERRE DEL GRID  -->


    {{-- =====================================================
         RESEÑAS (fuera del grid, correctamente alineado)
    ====================================================== --}}
    <section class="reviews">
        <h2>Reseñas de la Comunidad</h2>

        <div class="no-review-box">
            <i class="far fa-comment"></i>
            <p>Aún no hay reseñas</p>
            <small>Compra este juego para dejar tu reseña</small>
        </div>
    </section>


</div> <!-- wrapper -->



{{-- =====================================================
      SCRIPTS
===================================================== --}}
<script>
    // Switch thumbnails
    document.querySelectorAll(".hero-thumb").forEach(t => {
        t.addEventListener("click", () => {
            document.getElementById("heroMainImage").src = t.dataset.img;

            document.querySelector(".hero-thumb.active")?.classList.remove("active");
            t.classList.add("active");
        });
    });

    // Tabs
    document.querySelectorAll(".tab").forEach(tab => {
        tab.onclick = () => {
            document.querySelector(".tab.active")?.classList.remove("active");
            tab.classList.add("active");

            document.querySelector(".tab-content.active")?.classList.remove("active");
            document.getElementById("tab-" + tab.dataset.tab).classList.add("active");
        };
    });
</script>

@endsection