// ============================================================
// DASHBOARD – EVENTOS PRINCIPALES
// ============================================================

document.addEventListener("DOMContentLoaded", () => {

    console.log("Dashboard cargado correctamente");

    // ============================================================
    // USER DROPDOWN
    // ============================================================
    const userProfile = document.querySelector(".user-profile");
    const userDropdown = document.querySelector(".user-dropdown");

    if (userProfile && userDropdown) {
        userProfile.addEventListener("click", (e) => {
            e.stopPropagation();
            userDropdown.classList.toggle("show");
        });

        document.addEventListener("click", () => {
            userDropdown.classList.remove("show");
        });
    }

    // ============================================================
    // ADMIN DROPDOWN
    // ============================================================
    const adminNav = document.querySelector(".admin-nav");
    const navDropdown = document.querySelector(".nav-dropdown-menu");

    if (adminNav && navDropdown) {
        adminNav.addEventListener("click", (e) => {
            e.preventDefault();
            e.stopPropagation();
            navDropdown.classList.toggle("show");
        });

        document.addEventListener("click", () => {
            navDropdown.classList.remove("show");
        });
    }

    // ============================================================
    // ICONOS SUPERIORES
    // ============================================================
    const cartIcon = document.querySelector(".cart-icon");
    const messagesIcon = document.querySelector(".messages-icon");

    if (cartIcon) {
        cartIcon.addEventListener("click", () => {
            showToast("Carrito de compras — Función en desarrollo", "info");
        });
    }

    if (messagesIcon) {
        messagesIcon.addEventListener("click", () => {
            showToast("Centro de notificaciones — Próximamente", "info");
        });
    }

    // ============================================================
    // WISHLIST (CORAZÓN)
    // ============================================================
    document.querySelectorAll(".wishlist-btn").forEach(btn => {

        btn.addEventListener("click", async (e) => {
            e.stopPropagation();

            const icon = btn.querySelector("i");
            const gameTitle = btn.dataset.title || "Producto";

            // Estado actual
            const isInactive = icon.classList.contains("far");

            // Cambiar visual
            icon.classList.toggle("far", !isInactive);
            icon.classList.toggle("fas", isInactive);
            icon.style.color = isInactive ? "#ef4444" : "white";

            // Toast
            showToast(
                `${gameTitle} ${isInactive ? "agregado" : "eliminado"} de tu wishlist`,
                isInactive ? "success" : "warning"
            );
        });
    });

    // ============================================================
    // BUSCADOR
    // ============================================================
    const searchInput = document.querySelector(".search-bar input");

    if (searchInput) {
        searchInput.addEventListener("keypress", (e) => {
            if (e.key === "Enter") {
                const value = searchInput.value.trim();
                if (value) showToast(`Buscando "${value}"...`, "info");
            }
        });
    }

    // ============================================================
    // COMMUNITY PANEL
    // ============================================================
    const btnCommunity = document.getElementById("openCommunity");
    const panelCommunity = document.getElementById("communityPanel");

    if (btnCommunity && panelCommunity) {
        btnCommunity.addEventListener("click", () => {
            panelCommunity.classList.toggle("active");
        });
    }

    // ============================================================
    // FILTROS (Placeholder)
    // ============================================================
    const filtersBtn = document.querySelector(".filters-btn-vertical");

    if (filtersBtn) {
        filtersBtn.addEventListener("click", () =>
            showToast("Panel de filtros en desarrollo", "info")
        );
    }

});
