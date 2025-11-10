// home.js - XP Store Interactive Features

document.addEventListener('DOMContentLoaded', function () {

    // ===== CAROUSEL HERO FUNCTIONALITY =====
    const indicators = document.querySelectorAll('.indicator');
    const heroGames = [
        {
            title: 'God Of War Ragnarok',
            description: 'Embárcate en una aventura épica en un mundo lleno de mitología nórdica y criaturas legendarias.',
            image: 'https://wallpapers.com/images/high/kratos-in-cave-god-of-war-ragnarok-hmaawiodgr64ldzm.webp',
            tags: ['Aventura', 'Acción', 'Exploración'],
            price: '$249.99'
        },
        {
            title: 'Grand Theft Auto V',
            description: 'Explora Los Santos, una ciudad llena de acción y crimen. Vive la historia de tres criminales en busca de poder y libertad en un mundo abierto lleno de aventuras.',
            image: 'https://wallpapers.com/images/high/4k-gta-5-franklin-looking-at-city-at-night-bq6nlp808hn0xoi5.webpv',
            tags: ['Acción', 'Aventura', 'Mundo Abierto', 'Crimen'],
            price: '$59.99'
        },
        {
            title: 'Marvel’s Spider-Man 2',
            description: 'Balancea por Nueva York y enfrenta a nuevos villanos mientras controlas a Peter Parker y Miles Morales en esta épica aventura.',
            image: 'https://wallpapers.com/images/high/spider-man-ps4-4k-i5ssgd6fq17lrz7i.webp',
            tags: ['Acción', 'Aventura', 'Superhéroes'],
            price: '$199.99'
        },
        {
            title: 'Horizon Zero Dawn',
            description: 'Embárcate en una aventura épica en un mundo post-apocalíptico lleno de máquinas y misterios.',
            image: 'https://wallpapers.com/images/high/horizon-zero-dawn-nighttime-screenshot-yft9z5fm7kbaymmg.webp',
            tags: ['Acción', 'Aventura', 'Mundo Abierto'],
            price: '$99.99'
        }
    ];

    let currentSlide = 1; // Empezamos en el índice 1 (segundo juego)

    function updateHero(index) {
        const hero = heroGames[index];
        const heroSection = document.querySelector('.hero-section');
        const heroBackground = document.querySelector('.hero-background img');
        const heroTitle = document.querySelector('.hero-title');
        const heroDescription = document.querySelector('.hero-description');
        const heroTags = document.querySelector('.hero-tags');
        const heroPrice = document.querySelector('.price');

        // Fade out
        heroSection.style.opacity = '0.7';

        setTimeout(() => {
            // Update content
            heroBackground.src = hero.image;
            heroTitle.textContent = hero.title;
            heroDescription.textContent = hero.description;
            heroPrice.textContent = hero.price;

            // Update tags
            heroTags.innerHTML = hero.tags.map(tag =>
                `<span class="tag">${tag}</span>`
            ).join('');

            // Update indicators
            indicators.forEach((ind, i) => {
                ind.classList.toggle('active', i === index);
            });

            // Fade in
            heroSection.style.opacity = '1';
        }, 300);
    }

    // Auto rotate carousel every 5 seconds
    setInterval(() => {
        currentSlide = (currentSlide + 1) % heroGames.length;
        updateHero(currentSlide);
    }, 5000);

    // Manual control with indicators
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            currentSlide = index;
            updateHero(index);
        });
    });


    // ===== WISHLIST FUNCTIONALITY =====
    const wishlistBtns = document.querySelectorAll('.wishlist-btn');

    wishlistBtns.forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const icon = this.querySelector('i');

            if (icon.classList.contains('far')) {
                icon.classList.remove('far');
                icon.classList.add('fas');
                this.style.background = 'rgba(239, 68, 68, 0.9)';
                showNotification('Agregado a favoritos ❤️');
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
                this.style.background = 'rgba(255, 255, 255, 0.1)';
                showNotification('Eliminado de favoritos');
            }
        });
    });


    // ===== ADD TO CART FUNCTIONALITY =====
    const addCartBtns = document.querySelectorAll('.btn-add-cart');

    addCartBtns.forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const gameCard = this.closest('.game-card');
            const gameTitle = gameCard.querySelector('.game-title').textContent;

            // Change button state
            this.innerHTML = '<i class="fas fa-check"></i> En Carrito';
            this.style.background = 'linear-gradient(135deg, #10b981, #059669)';
            this.disabled = true;

            showNotification(`${gameTitle} agregado al carrito 🛒`);

            // Animate card
            gameCard.style.transform = 'translateY(-8px) scale(0.98)';
            setTimeout(() => {
                gameCard.style.transform = 'translateY(-8px) scale(1)';
            }, 200);
        });
    });


    // ===== FILTERS BUTTON ANIMATION =====
    const filtersBtn = document.querySelector('.filters-btn-vertical');

    if (filtersBtn) {
        filtersBtn.addEventListener('click', function () {
            showNotification('Panel de filtros (próximamente) 🎮');
            this.style.transform = 'translateY(-50%) translateX(10px) rotate(5deg)';
            setTimeout(() => {
                this.style.transform = 'translateY(-50%) translateX(0) rotate(0deg)';
            }, 200);
        });
    }


    // ===== SEARCH FUNCTIONALITY =====
    const searchInput = document.querySelector('.search-bar input');

    if (searchInput) {
        searchInput.addEventListener('focus', function () {
            this.parentElement.style.transform = 'scale(1.02)';
        });

        searchInput.addEventListener('blur', function () {
            this.parentElement.style.transform = 'scale(1)';
        });

        searchInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                const searchTerm = this.value.trim();
                if (searchTerm) {
                    showNotification(`Buscando: "${searchTerm}" 🔍`);
                    // Aquí irá la lógica de búsqueda real
                }
            }
        });
    }


    // ===== GAME CARD CLICK =====
    const gameCards = document.querySelectorAll('.game-card');

    gameCards.forEach(card => {
        card.addEventListener('click', function (e) {
            // Don't trigger if clicking on buttons
            if (!e.target.closest('button')) {
                const gameTitle = this.querySelector('.game-title').textContent;
                showNotification(`Abriendo detalles de ${gameTitle}...`);
                // Aquí irá la navegación a la página de detalles
            }
        });
    });


    // ===== VIEW DETAILS BUTTONS =====
    const viewDetailsBtns = document.querySelectorAll('.btn-view-details');

    viewDetailsBtns.forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const gameCard = this.closest('.game-card');
            const gameTitle = gameCard.querySelector('.game-title').textContent;
            showNotification(`Cargando ${gameTitle}...`);
        });
    });


    // ===== AUTH BUTTONS =====
    const btnLogin = document.querySelector('.btn-login');
    const btnRegister = document.querySelector('.btn-register');

    if (btnLogin) {
        btnLogin.addEventListener('click', function () {
            showNotification('Redirigiendo a Iniciar Sesión... 🔐');
        });
    }

    if (btnRegister) {
        btnRegister.addEventListener('click', function () {
            showNotification('Redirigiendo a Registro... ✨');
        });
    }


    // ===== NOTIFICATION SYSTEM =====
    function showNotification(message) {
        // Remove existing notification if any
        const existingNotification = document.querySelector('.notification');
        if (existingNotification) {
            existingNotification.remove();
        }

        // Create notification
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.textContent = message;

        // Add styles
        Object.assign(notification.style, {
            position: 'fixed',
            top: '100px',
            right: '20px',
            background: 'linear-gradient(135deg, #8b5cf6, #3b82f6)',
            color: 'white',
            padding: '1rem 1.5rem',
            borderRadius: '12px',
            boxShadow: '0 10px 40px rgba(139, 92, 246, 0.5)',
            zIndex: '1000',
            animation: 'slideIn 0.3s ease',
            fontWeight: '600',
            maxWidth: '300px'
        });

        document.body.appendChild(notification);

        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }


    // ===== ADD ANIMATION KEYFRAMES =====
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }
        
        /* Smooth transitions */
        .hero-section {
            transition: opacity 0.3s ease;
        }
        
        .game-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    `;
    document.head.appendChild(style);


    // ===== SCROLL ANIMATIONS =====
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe all game cards
    gameCards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
        observer.observe(card);
    });


    // ===== PARALLAX EFFECT ON HERO =====
    window.addEventListener('scroll', function () {
        const heroBackground = document.querySelector('.hero-background img');
        if (heroBackground) {
            const scrolled = window.pageYOffset;
            heroBackground.style.transform = `translateY(${scrolled * 0.5}px)`;
        }
    });


    // ===== CONSOLE WELCOME MESSAGE =====
    console.log('%c🎮 XP STORE 🎮', 'color: #8b5cf6; font-size: 24px; font-weight: bold;');
    console.log('%cBienvenido al mejor marketplace de videojuegos!', 'color: #3b82f6; font-size: 14px;');
    console.log('%cVersión: 1.0.0 | Laravel + Vanilla JS', 'color: #10b981; font-size: 12px;');
});


// ===== UTILITY FUNCTIONS =====

// Format price
function formatPrice(price) {
    return `$${parseFloat(price).toFixed(2)}`;
}

// Calculate discount price
function calculateDiscountPrice(originalPrice, discountPercent) {
    const discount = originalPrice * (discountPercent / 100);
    return originalPrice - discount;
}

// Debounce function for search
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}