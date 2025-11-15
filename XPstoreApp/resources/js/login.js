// Funcionalidades del formulario de login
document.addEventListener('DOMContentLoaded', function () {
    // Inicializar partículas
    initParticles();

    // Inicializar funcionalidades
    initPasswordToggle();
    initTestCredentials();
    initGreetingAnimation();
    initFormAnimations();
});

// Generar partículas
function initParticles() {
    const container = document.getElementById('particles-container');
    const particleCount = 30;

    for (let i = 0; i < particleCount; i++) {
        createParticle(container, i);
    }
}

function createParticle(container, id) {
    const particle = document.createElement('div');
    particle.className = 'particle';

    const size = Math.random() * 8 + 2;
    const x = Math.random() * 100;
    const y = Math.random() * 100;
    const duration = Math.random() * 20 + 10;
    const delay = Math.random() * 5;

    // Colores aleatorios para las partículas
    const colors = [
        'rgba(168, 85, 247, 0.4)',
        'rgba(59, 130, 246, 0.4)',
        'rgba(236, 72, 153, 0.4)'
    ];
    const color = colors[id % 3];

    particle.style.cssText = `
        left: ${x}%;
        top: ${y}%;
        width: ${size}px;
        height: ${size}px;
        background: radial-gradient(circle, ${color}, transparent);
        animation: particleFloat ${duration}s infinite ${delay}s ease-in-out;
    `;

    container.appendChild(particle);
}

// Añadir animación de partículas al CSS dinámicamente
const style = document.createElement('style');
style.textContent = `
    @keyframes particleFloat {
        0%, 100% {
            transform: translate(0, 0) scale(0.5);
            opacity: 0;
        }
        50% {
            transform: translate(${Math.sin(Date.now()) * 50}px, -100px) scale(1);
            opacity: 1;
        }
    }
`;
document.head.appendChild(style);

// Toggle de visibilidad de contraseña
function initPasswordToggle() {
    const passwordToggle = document.querySelector('.password-toggle');
    const passwordInput = document.getElementById('password');

    if (passwordToggle && passwordInput) {
        passwordToggle.addEventListener('click', function () {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            this.classList.toggle('show-password', isPassword);
        });
    }
}

// Credenciales de prueba
function initTestCredentials() {
    const testButton = document.getElementById('test-credentials');

    if (testButton) {
        testButton.addEventListener('click', function () {
            document.getElementById('email').value = 'gamer@xpstore.com';
            document.getElementById('password').value = 'password123';
            showToast('Credenciales de prueba cargadas', 'success');
        });
    }
}

// Animación de saludos para móviles
function initGreetingAnimation() {
    if (window.innerWidth < 1024) {
        const greetings = [
            { icon: '🎮', text: '¡Listo para jugar!' },
            { icon: '🏆', text: '¡Bienvenido campeón!' },
            { icon: '⚡', text: '¡A ganar XP!' },
            { icon: '✨', text: '¡Tu aventura espera!' }
        ];

        let currentGreeting = 0;
        const greetingCard = document.querySelector('.greeting-card');
        const greetingIcon = document.querySelector('.greeting-icon');
        const greetingText = document.querySelector('.greeting-text');

        setInterval(() => {
            currentGreeting = (currentGreeting + 1) % greetings.length;
            const greeting = greetings[currentGreeting];

            // Animación de transición
            greetingCard.style.opacity = '0';
            greetingCard.style.transform = 'translateY(-10px)';

            setTimeout(() => {
                greetingIcon.textContent = greeting.icon;
                greetingText.textContent = greeting.text;

                greetingCard.style.opacity = '1';
                greetingCard.style.transform = 'translateY(0)';
            }, 300);
        }, 3000);
    }
}

// Animaciones de formulario
function initFormAnimations() {
    const inputs = document.querySelectorAll('.form-input');

    inputs.forEach(input => {
        input.addEventListener('focus', function () {
            this.parentElement.classList.add('focused');
        });

        input.addEventListener('blur', function () {
            this.parentElement.classList.remove('focused');
        });
    });

    // Efecto de carga en el botón de login
    const loginButton = document.getElementById('login-button');
    const loginForm = document.querySelector('.login-form');

    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            const button = this.querySelector('.login-button');
            if (button && !button.disabled) {
                button.disabled = true;
                button.innerHTML = `
                    <div class="loading-spinner">
                        <svg class="button-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <span class="button-text">Iniciando sesión...</span>
                `;

                // Simular tiempo de carga (en producción esto sería real)
                setTimeout(() => {
                    button.disabled = false;
                    button.innerHTML = `
                        <div class="button-shine"></div>
                        <svg class="button-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M13.8 12H3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="button-text">Iniciar Sesión</span>
                    `;
                }, 2000);
            }
        });
    }
}

// Sistema de notificaciones Toast
function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;

    const icon = type === 'success' ?
        '<svg class="toast-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 6L9 17l-5-5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>' :
        '<svg class="toast-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';

    toast.innerHTML = `${icon}${message}`;
    container.appendChild(toast);

    // Auto-remover después de 5 segundos
    setTimeout(() => {
        toast.style.animation = 'toastSlideIn 0.3s ease-out reverse';
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 300);
    }, 5000);
}

// Efectos de hover mejorados
document.addEventListener('DOMContentLoaded', function () {
    const cards = document.querySelectorAll('.feature-card, .credentials-info');

    cards.forEach(card => {
        card.addEventListener('mouseenter', function () {
            this.style.transform = 'translateY(-5px) scale(1.02)';
        });

        card.addEventListener('mouseleave', function () {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
});

// Validación de formulario en tiempo real
function initFormValidation() {
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');

    if (emailInput) {
        emailInput.addEventListener('input', function () {
            validateEmail(this);
        });
    }

    if (passwordInput) {
        passwordInput.addEventListener('input', function () {
            validatePassword(this);
        });
    }
}

function validateEmail(input) {
    const email = input.value;
    const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);

    if (email && !isValid) {
        input.style.borderColor = '#ef4444';
        input.style.boxShadow = '0 0 0 2px rgba(239, 68, 68, 0.2)';
    } else {
        input.style.borderColor = '';
        input.style.boxShadow = '';
    }

    return isValid;
}

function validatePassword(input) {
    const password = input.value;
    const isValid = password.length >= 6;

    if (password && !isValid) {
        input.style.borderColor = '#ef4444';
        input.style.boxShadow = '0 0 0 2px rgba(239, 68, 68, 0.2)';
    } else {
        input.style.borderColor = '';
        input.style.boxShadow = '';
    }

    return isValid;
}

// Inicializar validación
initFormValidation();