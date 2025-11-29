<header class="header">
    <div class="container">
        <div class="header-content">
            <!-- Logo -->
            <div class="logo">
                <div class="logo-icon">
                    <i class="fas fa-gamepad"></i>
                </div>
                <div class="logo-text">
                    <span class="logo-xp">XP</span>
                    <span class="logo-store">STORE</span>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Busca juegos, recargas y más" id="searchInput">
            </div>

            <!-- User Menu -->
            <div class="user-menu">


                <a href="{{ route('cart.index') }}" class="cart-icon" id="cartIcon">
                    <i class="fas fa-shopping-cart"></i>
                    @php
                    $cart = session('cart', []);
                    $cartItems = session('cart_items', []);
                    $cartCount = collect($cart)->sum('quantity') + collect($cartItems)->sum('quantity');
                    @endphp
                    @if($cartCount > 0)
                    <span class="cart-count" id="cartCount">{{ $cartCount }}</span>
                    @endif
                </a>

                <div class="messages-icon" id="notificationsIcon">
                    <i class="fas fa-bell"></i>
                    @php
                    $notificationCount = 0; // Puedes cambiarlo cuando tengas notificaciones reales
                    @endphp
                    @if($notificationCount > 0)
                    <span class="notification-count" id="notificationCount">{{ $notificationCount }}</span>
                    @endif
                </div>

                <div class="user-profile">
                    @php
                    $avatar = auth()->user()->avatar ?? null;
                    $isUrl = $avatar && Str::startsWith($avatar, ['http://', 'https://']);
                    @endphp

                    <div class="user-avatar">
                        @if(auth()->user()->avatar)

                        @if($avatar)
                        <img src="{{ $isUrl ? $avatar : asset('storage/'.$avatar) }}" alt="Avatar" class="avatar-thumb">
                        @else
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}">
                        @endif

                        @else
                        <i class="fas fa-user"></i>
                        @endif
                    </div>


                    <span class="user-name">
                        {{ auth()->user()->name }}
                    </span>
                    <i class="fas fa-chevron-down"></i>

                    <!-- Dropdown Menu -->
                    <div class="user-dropdown">
                        @if(auth()->user()->role === 'admin')
                        <a href="{{ route('dashboard.admin') }}" class="dropdown-item admin-item">
                            <i class="fas fa-crown"></i>
                            Panel de Administrador
                        </a>
                        <div class="dropdown-divider"></div>
                        @endif

                        <a href="{{ route('profile.index') }}" class="dropdown-item">
                            <i class="fas fa-user"></i>
                            Mi Perfil
                        </a>
                        <a href="{{ route('purchases.index') }}" class="dropdown-item">
                            <i class="fas fa-shopping-bag"></i>
                            Mis Compras
                        </a>
                        <a href="{{ route('wishlist.index') }}" class="dropdown-item">
                            <i class="fas fa-heart"></i>
                            Wishlist
                        </a>
                        <a href="{{ route('settings.index') }}" class="dropdown-item">
                            <i class="fas fa-cog"></i>
                            Configuración
                        </a>

                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}" class="dropdown-form">
                            @csrf
                            <button type="submit" class="dropdown-item logout-item">
                                <i class="fas fa-sign-out-alt"></i>
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<nav class="nav-bar">
    <div class="container">
        <a href="{{ route('dashboard.user') }}" class="nav-link {{ request()->routeIs('dashboard.user') ? 'active' : '' }}">Catálogo</a>
        <a href="{{ route('marketplace.index') }}" class="nav-link {{ request()->routeIs('marketplace.index') ? 'active' : '' }}">Marketplace</a>
        <a href="{{ route('streaming.index') }}" class="nav-link {{ request()->routeIs('streaming.index') ? 'active' : '' }}">Códigos</a>
        <a href="{{ route('library.index') }}" class="nav-link">Mis Pedidos</a>

    </div>
</nav>