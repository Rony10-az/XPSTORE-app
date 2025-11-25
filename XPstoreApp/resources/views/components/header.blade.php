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

                    <span class="cart-count" id="cartCount">
                        {{ session('cart') ? collect(session('cart'))->sum('quantity') : 0 }}
                    </span>

                </a>



                <div class="messages-icon" id="notificationsIcon">
                    <i class="fas fa-bell"></i>
                    <span class="notification-count" id="notificationCount">0</span>
                </div>

                <div class="user-profile">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <span class="user-name">
                        {{ auth()->user()->name }}
                    </span>
                    <i class="fas fa-chevron-down"></i>

                    <!-- Dropdown Menu -->
                    <div class="user-dropdown">
                        <a href="{{ route('profile.index') }}" class="dropdown-item">
                            <i class="fas fa-user"></i>
                            Mi Perfil
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-shopping-bag"></i>
                            Mis Compras
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-heart"></i>
                            Wishlist
                        </a>
                        <a href="#" class="dropdown-item">
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
        <a href="#}" class="nav-link">Marketplace</a>
        <a href="#" class="nav-link">Códigos</a>
        <a href="{{ route('library.index') }}" class="nav-link">Mis Pedidos</a>
        <a href="#" class="nav-link">Wishlist</a>
    </div>
</nav>