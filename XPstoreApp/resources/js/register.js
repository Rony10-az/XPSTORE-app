// register.js - Funcionalidades específicas para el registro

document.addEventListener('DOMContentLoaded', function () {
    // ===== INICIALIZACIÓN =====
    initializeRegisterForm();
    setupPasswordStrength();
    setupParticles();

    // ===== TOGGLE VISIBILIDAD DE CONTRASEÑA =====
    const passwordToggles = document.querySelectorAll('.password-toggle');
    passwordToggles.forEach(toggle => {
        toggle.addEventListener('click', function () {
            const input = this.closest('.input-container').querySelector('.password-input');
            const eyeOpen = this.querySelector('.eye-open');
            const eyeClosed = this.querySelector('.eye-closed');

            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.style.display = 'none';
                eyeClosed.style.display = 'block';
            } else {
                input.type = 'password';
                eyeOpen.style.display = 'block';
                eyeClosed.style.display = 'none';
            }
        });
    });

    // ===== VALIDACIÓN EN TIEMPO REAL =====
    setupRealTimeValidation();

    // ===== ANIMACIONES DE ENFOQUE =====
    setupFocusAnimations();
});

// ===== FUNCIONES PRINCIPALES =====

function initializeRegisterForm() {
    const registerForm = document.querySelector('.register-form');
    const registerButton = document.getElementById('register-button');

    if (registerForm) {
        registerForm.addEventListener('submit', function (e) {
            e.preventDefault();

            if (validateForm()) {
                showLoadingState();
                // En producción, aquí se enviaría el formulario
                setTimeout(() => {
                    this.submit();
                }, 1500);
            }
        });
    }
}

function setupPasswordStrength() {
    const passwordInput = document.getElementById('password');
    const strengthFill = document.getElementById('strengthFill');
    const strengthText = document.getElementById('strengthText');

    if (passwordInput && strengthFill && strengthText) {
        passwordInput.addEventListener('input', function () {
            const password = this.value;
            const strength = calculatePasswordStrength(password);

            updateStrengthIndicator(strength, strengthFill, strengthText);
        });
    }
}

function setupRealTimeValidation() {
    const inputs = document.querySelectorAll('.form-input');

    inputs.forEach(input => {
        input.addEventListener('blur', function () {
            validateField(this);
        });

        input.addEventListener('input', function () {
            clearFieldError(this);
        });
    });
}

function setupFocusAnimations() {
    const inputs = document.querySelectorAll('.form-input');

    inputs.forEach(input => {
        input.addEventListener('focus', function () {
            this.parentElement.classList.add('focused');
        });

        input.addEventListener('blur', function () {
            this.parentElement.classList.remove('focused');
        });
    });
}

// ===== FUNCIONES DE VALIDACIÓN =====

function validateForm() {
    let isValid = true;
    const inputs = document.querySelectorAll('.form-input[required]');

    inputs.forEach(input => {
        if (!validateField(input)) {
            isValid = false;
        }
    });

    // Validar términos y condiciones
    const termsCheckbox = document.getElementById('terms');
    if (termsCheckbox && !termsCheckbox.checked) {
        showToast('Debes aceptar los términos y condiciones', 'error');
        isValid = false;
    }

    // Validar confirmación de contraseña
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('password_confirmation');

    if (password && confirmPassword && password.value !== confirmPassword.value) {
        showFieldError(confirmPassword, 'Las contraseñas no coinciden');
        isValid = false;
    }

    return isValid;
}

function validateField(field) {
    const value = field.value.trim();
    let isValid = true;
    let errorMessage = '';

    switch (field.type) {
        case 'text':
            if (field.name === 'name' && value.length < 2) {
                errorMessage = 'El nombre debe tener al menos 2 caracteres';
                isValid = false;
            }
            break;

        case 'email':
            if (!isValidEmail(value)) {
                errorMessage = 'Por favor, ingresa un email válido';
                isValid = false;
            }
            break;

        case 'password':
            if (value.length < 8) {
                errorMessage = 'La contraseña debe tener al menos 8 caracteres';
                isValid = false;
            }
            break;
    }

    if (!isValid && errorMessage) {
        showFieldError(field, errorMessage);
    } else {
        clearFieldError(field);
        showFieldSuccess(field);
    }

    return isValid;
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// ===== INDICADOR DE FORTALEZA DE CONTRASEÑA =====

function calculatePasswordStrength(password) {
    let strength = 0;

    if (password.length >= 8) strength += 25;
    if (/[a-z]/.test(password)) strength += 25;
    if (/[A-Z]/.test(password)) strength += 25;
    if (/[0-9]/.test(password)) strength += 15;
    if (/[^a-zA-Z0-9]/.test(password)) strength += 10;

    return Math.min(strength, 100);
}

function updateStrengthIndicator(strength, strengthFill, strengthText) {
    // Actualizar barra de progreso
    strengthFill.style.width = `${strength}%`;

    // Actualizar color y texto
    if (strength < 40) {
        strengthFill.style.background = 'var(--error)';
        strengthText.textContent = 'Contraseña débil';
        strengthText.style.color = 'var(--error)';
    } else if (strength < 70) {
        strengthFill.style.background = 'var(--warning)';
        strengthText.textContent = 'Contraseña moderada';
        strengthText.style.color = 'var(--warning)';
    } else {
        strengthFill.style.background = 'var(--success)';
        strengthText.textContent = 'Contraseña fuerte';
        strengthText.style.color = 'var(--success)';
    }
}

// ===== MANEJO DE ERRORES =====

function showFieldError(field, message) {
    clearFieldError(field);

    const errorElement = document.createElement('div');
    errorElement.className = 'field-error';
    errorElement.textContent = message;
    errorElement.style.cssText = `
        color: var(--error);
        font-size: 0.75rem;
        margin-top: 0.25rem;
        animation: fadeIn 0.3s ease;
    `;

    field.parentElement.appendChild(errorElement);
    field.style.borderColor = 'var(--error)';
}

function clearFieldError(field) {
    const existingError = field.parentElement.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
    field.style.borderColor = '';
}

function showFieldSuccess(field) {
    field.style.borderColor = 'var(--success)';

    // Remover el color de éxito después de un tiempo
    setTimeout(() => {
        if (field.style.borderColor === 'var(--success)') {
            field.style.borderColor = '';
        }
    }, 2000);
}

// ===== ESTADOS DE CARGA =====

function showLoadingState() {
    const button = document.getElementById('register-button');
    const buttonText = button.querySelector('.button-text');
    const originalText = buttonText.textContent;

    button.disabled = true;
    buttonText.textContent = 'Creando cuenta...';
    button.style.opacity = '0.8';

    // Restaurar después de 3 segundos (en producción, esto se haría después de la respuesta del servidor)
    setTimeout(() => {
        button.disabled = false;
        buttonText.textContent = originalText;
        button.style.opacity = '1';
    }, 3000);
}

// ===== SISTEMA DE TOAST =====

function showToast(message, type = 'info') {
    const toastContainer = document.getElementById('toast-container');
    if (!toastContainer) return;

    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <div class="toast-content">
            <i class="toast-icon"></i>
            <span class="toast-message">${message}</span>
        </div>
        <button class="toast-close">&times;</button>
    `;

    // Estilos básicos del toast
    toast.style.cssText = `
        background: ${getToastColor(type)};
        color: white;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        animation: slideInRight 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    `;

    const closeBtn = toast.querySelector('.toast-close');
    closeBtn.addEventListener('click', () => {
        toast.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    });

    toastContainer.appendChild(toast);

    // Auto-remover después de 5 segundos
    setTimeout(() => {
        if (toast.parentElement) {
            toast.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }
    }, 5000);
}

function getToastColor(type) {
    const colors = {
        success: 'var(--success)',
        error: 'var(--error)',
        warning: 'var(--warning)',
        info: 'var(--primary)'
    };
    return colors[type] || colors.info;
}

// ===== PARTÍCULAS ANIMADAS =====

function setupParticles() {
    const container = document.getElementById('particles-container');
    if (!container) return;

    const particleCount = 30;

    for (let i = 0; i < particleCount; i++) {
        createParticle(container);
    }
}

function createParticle(container) {
    const particle = document.createElement('div');
    particle.className = 'particle';

    // Posición aleatoria
    const posX = Math.random() * 100;
    const posY = Math.random() * 100;

    // Tamaño aleatorio
    const size = Math.random() * 3 + 1;

    // Opacidad aleatoria
    const opacity = Math.random() * 0.5 + 0.1;

    // Duración de animación aleatoria
    const duration = Math.random() * 20 + 10;

    particle.style.cssText = `
        position: absolute;
        width: ${size}px;
        height: ${size}px;
        background: rgba(255, 255, 255, ${opacity});
        border-radius: 50%;
        left: ${posX}%;
        top: ${posY}%;
        animation: floatParticle ${duration}s linear infinite;
        pointer-events: none;
    `;

    container.appendChild(particle);
}

// ===== ANIMACIONES CSS ADICIONALES =====

// Agregar estilos CSS dinámicamente para las nuevas animaciones
const style = document.createElement('style');
style.textContent = `
    @keyframes floatParticle {
        0% {
            transform: translateY(100vh) rotate(0deg);
            opacity: 0;
        }
        10% {
            opacity: 1;
        }
        90% {
            opacity: 1;
        }
        100% {
            transform: translateY(-100px) rotate(360deg);
            opacity: 0;
        }
    }
    
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
    
    .input-container.focused {
        transform: translateY(-1px);
    }
    
    .field-error {
        color: var(--error);
        font-size: 0.75rem;
        margin-top: 0.25rem;
        animation: fadeIn 0.3s ease;
    }
`;
document.head.appendChild(style);

// ===== MANEJO DE TECLADO =====

document.addEventListener('keydown', function (e) {
    // Enter en el formulario
    if (e.key === 'Enter' && e.target.classList.contains('form-input')) {
        e.preventDefault();
        const form = e.target.closest('.register-form');
        if (form) {
            form.dispatchEvent(new Event('submit'));
        }
    }
});

// ===== OPTIMIZACIONES DE PERFORMANCE =====

// Debounce para validaciones en tiempo real
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

// Aplicar debounce a la validación de fortaleza de contraseña
const debouncedPasswordStrength = debounce((password, strengthFill, strengthText) => {
    const strength = calculatePasswordStrength(password);
    updateStrengthIndicator(strength, strengthFill, strengthText);
}, 300);

// Reemplazar el event listener original con la versión debounced
document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.getElementById('password');
    const strengthFill = document.getElementById('strengthFill');
    const strengthText = document.getElementById('strengthText');

    if (passwordInput && strengthFill && strengthText) {
        passwordInput.addEventListener('input', function () {
            debouncedPasswordStrength(this.value, strengthFill, strengthText);
        });
    }
});