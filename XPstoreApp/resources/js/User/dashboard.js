// ============================================================
// DASHBOARD – EVENTOS PRINCIPALES
// ============================================================

document.addEventListener('DOMContentLoaded', () => {

    console.log('Dashboard cargado correctamente');

    // ================================
    // USER DROPDOWN
    // ================================
    const userProfile = document.querySelector('.user-profile');
    const userDropdown = document.querySelector('.user-dropdown');

    if (userProfile && userDropdown) {
        userProfile.addEventListener('click', (e) => {
            e.stopPropagation();
            userDropdown.classList.toggle('show');
        });

        document.addEventListener('click', () => {
            userDropdown.classList.remove('show');
        });
    }

    // ================================
    // ADMIN DROPDOWN
    // ================================
    const adminNav = document.querySelector('.admin-nav');
    const navDropdown = document.querySelector('.nav-dropdown-menu');

    if (adminNav && navDropdown) {
        adminNav.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            navDropdown.classList.toggle('show');
        });

        document.addEventListener('click', () => {
            navDropdown.classList.remove('show');
        });
    }

    // ================================
    // ICONOS SUPERIORES
    // ================================
    const cartIcon = document.querySelector('.cart-icon');
    const messagesIcon = document.querySelector('.messages-icon');

    if (cartIcon) {
        cartIcon.addEventListener('click', () =>
            showToast('Carrito de compras - Funcionalidad en desarrollo', 'info')
        );
    }

    if (messagesIcon) {
        messagesIcon.addEventListener('click', () =>
            showToast('Centro de notificaciones - Funcionalidad en desarrollo', 'info')
        );
    }

    // ================================
    // WISHLIST
    // ================================
    document.querySelectorAll('.wishlist-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.stopPropagation();
            const icon = this.querySelector('i');
            const title = this.closest('.game-card')?.querySelector('.game-title')?.textContent;

            if (!title || !icon) return;

            const adding = icon.classList.contains('far');

            icon.classList.toggle('far', !adding);
            icon.classList.toggle('fas', adding);
            icon.style.color = adding ? '#ef4444' : 'white';

            showToast(
                `${title} ${adding ? 'agregado' : 'removido'} de wishlist`,
                adding ? 'success' : 'info'
            );
        });
    });

    // ================================
    // BUSCADOR
    // ================================
    const searchInput = document.querySelector('.search-bar input');
    if (searchInput) {
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                const term = searchInput.value.trim();
                if (term) showToast(`Buscando: ${term}`, 'info');
            }
        });
    }

    // ================================
    // COMMUNITY PANEL
    // ================================
    const btnCommunity = document.getElementById("openCommunity");
    const panelCommunity = document.getElementById("communityPanel");

    if (btnCommunity && panelCommunity) {
        btnCommunity.addEventListener("click", () =>
            panelCommunity.classList.toggle("active")
        );
    }

    // ================================
    // FILTROS (placeholder)
    // ================================
    const filtersBtn = document.querySelector('.filters-btn-vertical');
    if (filtersBtn) {
        filtersBtn.addEventListener('click', () =>
            showToast('Panel de filtros - Funcionalidad en desarrollo', 'info')
        );
    }

});



// Animaciones (solo se cargan una vez)
if (!document.querySelector('#toast-styles')) {
    const style = document.createElement('style');
    style.id = 'toast-styles';
    style.textContent = `
        @keyframes toastSlideIn {
            from { transform: translateX(100%); opacity: 0; }
            to   { transform: translateX(0); opacity: 1; }
        }
        @keyframes toastSlideOut {
            from { transform: translateX(0); opacity: 1; }
            to   { transform: translateX(100%); opacity: 0; }
        }
    `;
    document.head.appendChild(style);
}
