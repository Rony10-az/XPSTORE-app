<footer class="footer">
    <div class="container">

        <div class="footer-content">

            {{-- LOGO + DESCRIPCIÓN --}}
            <div class="footer-section footer-about">
                <div class="logo">
                    <div class="logo-icon">
                        <i class="fas fa-gamepad"></i>
                    </div>
                    <div class="logo-text">
                        <span class="logo-xp">XP</span>
                        <span class="logo-store">STORE</span>
                    </div>
                </div>

                <p class="footer-description">
                    Tu tienda digital de videojuegos, ítems y códigos premium. Calidad garantizada.
                </p>

                {{-- REDES SOCIALES CENTRADAS --}}
                <div class="social-links">
                    <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://x.com/eneba_es"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="social-link">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="social-link"><i class="fab fa-discord"></i></a>
                    <a href="https://www.youtube.com/watch?v=A1T6cbXun0Q"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="social-link">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>

            {{-- ENLACES RÁPIDOS --}}
            <div class="footer-section">
                <h4>Enlaces Rápidos</h4>
                <a href="{{ route('dashboard.user') }}">Catálogo</a>
                <a href="{{ route('market.index') }}">Marketplace</a>
                <a href="{{ route('streaming.index') }}">Códigos</a>
                <a href="{{ route('library.index') }}">Mis Pedidos</a>
            </div>

            {{-- SOPORTE --}}
            <div class="footer-section">
                <h4>Soporte</h4>
                <a href="#">Centro de Ayuda</a>
                <a href="#">Contacto</a>
                <a href="#">Política de Reembolsos</a>
                <a href="#">Términos y Condiciones</a>
            </div>

            {{-- NEWSLETTER --}}
            <div class="footer-section">
                <h4>Newsletter</h4>
                <p>Recibe promociones exclusivas antes que nadie.</p>
                <form action="#" method="POST" class="newsletter-form">
                    @csrf
                    <input type="email" placeholder="Tu correo electrónico" required>
                    <button class="newsletter-btn">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>

        </div>

        {{-- COPYRIGHT --}}
        <div class="footer-bottom">
            <p>&copy; 2025 XP Store. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>