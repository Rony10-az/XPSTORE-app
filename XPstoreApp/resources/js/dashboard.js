// Dashboard específico
document.addEventListener('DOMContentLoaded', function () {
    console.log('Dashboard cargado correctamente');

    // User dropdown functionality
    const userProfile = document.querySelector('.user-profile');
    const userDropdown = document.querySelector('.user-dropdown');
    // Admin nav dropdown
    const adminNav = document.querySelector('.admin-nav');
    const navDropdown = document.querySelector('.nav-dropdown-menu');

    if (userProfile && userDropdown) {
        userProfile.addEventListener('click', function (e) {
            e.stopPropagation();
            userDropdown.classList.toggle('show');
        });
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function () {
        e.preventDefault();
        navDropdown.classList.toggle('show');

    });
    navDropdown.addEventListener('click', function (e) {
        e.stopPropagation();
    });




    if (adminNav && navDropdown) {
        adminNav.addEventListener('click', function (e) {
            e.preventDefault();
            navDropdown.classList.toggle('show');
        });
    }

    // Cart and notification icons interaction
    const cartIcon = document.querySelector('.cart-icon');
    const messagesIcon = document.querySelector('.messages-icon');

    if (cartIcon) {
        cartIcon.addEventListener('click', function () {
            showToast('Carrito de compras - Funcionalidad en desarrollo', 'info');
        });
    }

    if (messagesIcon) {
        messagesIcon.addEventListener('click', function () {
            showToast('Centro de notificaciones - Funcionalidad en desarrollo', 'info');
        });
    }

    // Continue playing buttons
    const continueButtons = document.querySelectorAll('.btn-continue');
    continueButtons.forEach(button => {
        button.addEventListener('click', function () {
            const gameTitle = this.closest('.game-card').querySelector('.game-title').textContent;
            showToast(`Continuar jugando: ${gameTitle}`, 'success');
        });
    });

    // Add to cart buttons
    const addToCartButtons = document.querySelectorAll('.btn-add-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function () {
            const gameTitle = this.closest('.game-card').querySelector('.game-title').textContent;
            showToast(`${gameTitle} agregado al carrito`, 'success');

            // Actualizar contador del carrito
            const cartCount = document.querySelector('.cart-count');
            if (cartCount) {
                let count = parseInt(cartCount.textContent) || 0;
                cartCount.textContent = count + 1;
            }
        });
    });

    // Wishlist buttons
    const wishlistButtons = document.querySelectorAll('.wishlist-btn');
    wishlistButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.stopPropagation();
            const icon = this.querySelector('i');
            const gameTitle = this.closest('.game-card').querySelector('.game-title').textContent;

            if (icon.classList.contains('far')) {
                icon.classList.replace('far', 'fas');
                icon.style.color = '#ef4444';
                showToast(`${gameTitle} agregado a wishlist`, 'success');
            } else {
                icon.classList.replace('fas', 'far');
                icon.style.color = 'white';
                showToast(`${gameTitle} removido de wishlist`, 'info');
            }
        });
    });

    // Welcome banner animation
    const welcomeBanner = document.querySelector('.welcome-banner');
    if (welcomeBanner) {
        welcomeBanner.style.opacity = '0';
        welcomeBanner.style.transform = 'translateY(20px)';

        setTimeout(() => {
            welcomeBanner.style.transition = 'all 0.6s ease';
            welcomeBanner.style.opacity = '1';
            welcomeBanner.style.transform = 'translateY(0)';
        }, 300);
    }

    // Stats counter animation
    const stats = document.querySelectorAll('.stat-item span');
    stats.forEach(stat => {
        const originalText = stat.textContent;
        const target = parseInt(originalText);
        if (!isNaN(target)) {
            let current = 0;
            const increment = target / 30;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                    stat.textContent = originalText; // Volver al texto original
                } else {
                    stat.textContent = Math.round(current);
                }
            }, 50);
        }
    });

    // Game cards hover effects
    const gameCards = document.querySelectorAll('.game-card');
    gameCards.forEach(card => {
        card.addEventListener('mouseenter', function () {
            this.style.transform = 'translateY(-8px)';
        });

        card.addEventListener('mouseleave', function () {
            this.style.transform = 'translateY(0)';
        });
    });

    // Search functionality
    const searchInput = document.querySelector('.search-bar input');
    if (searchInput) {
        searchInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                const searchTerm = this.value.trim();
                if (searchTerm) {
                    showToast(`Buscando: ${searchTerm}`, 'info');
                    // Aquí iría la lógica de búsqueda real
                }
            }
        });
    }

    // Navigation active state
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            if (this.getAttribute('href') === '#') {
                e.preventDefault();
            }

            navLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });
});

// Toast notifications para el dashboard
function showToast(message, type = 'success') {
    // Crear contenedor de toasts si no existe
    let toastContainer = document.getElementById('toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
            display: flex;
            flex-direction: column;
            gap: 10px;
        `;
        document.body.appendChild(toastContainer);
    }

    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.textContent = message;
    toast.style.cssText = `
        background: ${type === 'success' ? '#10b981' :
            type === 'error' ? '#ef4444' :
                type === 'info' ? '#3b82f6' : '#8b5cf6'};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        animation: toastSlideIn 0.3s ease;
        max-width: 300px;
        word-wrap: break-word;
        font-weight: 500;
    `;

    toastContainer.appendChild(toast);

    setTimeout(() => {
        toast.style.animation = 'toastSlideOut 0.3s ease';
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 300);
    }, 3000);
}

// Agregar estilos para las animaciones de toast
if (!document.querySelector('#toast-styles')) {
    const style = document.createElement('style');
    style.id = 'toast-styles';
    style.textContent = `
        @keyframes toastSlideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes toastSlideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
}

// Funcionalidad para el botón de filtros
const filtersBtn = document.querySelector('.filters-btn-vertical');
if (filtersBtn) {
    filtersBtn.addEventListener('click', function () {
        showToast('Panel de filtros - Funcionalidad en desarrollo', 'info');
    });
}