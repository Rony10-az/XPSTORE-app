// resources/js/admin.js
document.addEventListener('DOMContentLoaded', function () {
    console.log('Admin CRUD cargado');
    

    // Hice que las alertas se desvanezcan solas tras unos segundos.
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach((alert) => {
        setTimeout(() => {
            alert.classList.add('fade-out');
            setTimeout(() => alert.remove(), 400);
        }, 3500);
    });

    // Búsqueda en tiempo real
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function (e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.crud-table tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // Filtro por estado
    const statusFilter = document.getElementById('statusFilter');
    if (statusFilter) {
        statusFilter.addEventListener('change', function (e) {
            const filterValue = e.target.value;
            const rows = document.querySelectorAll('.crud-table tbody tr');

            rows.forEach(row => {
                if (!filterValue) {
                    row.style.display = '';
                    return;
                }

                const rowText = row.textContent.toLowerCase();

                switch (filterValue) {
                    case 'stock':
                        row.style.display = rowText.includes('en stock') ? '' : 'none';
                        break;
                    case 'out':
                        row.style.display = rowText.includes('sin stock') ? '' : 'none';
                        break;
                    case 'featured':
                        row.style.display = rowText.includes('destacado') ? '' : 'none';
                        break;
                    case 'discount':
                        row.style.display = rowText.includes('%') ? '' : 'none';
                        break;
                }
            });
        });
    }

    // Confirmación para eliminar
    const deleteForms = document.querySelectorAll('form[action*="destroy"]');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function (e) {
            if (!confirm('¿Estás seguro de que quieres eliminar este videojuego?')) {
                e.preventDefault();
            }
        });
    });

    // Actualizar colores de barras de stock
    function updateStockBars() {
        const stockBars = document.querySelectorAll('.progress-bar');
        stockBars.forEach(bar => {
            const width = parseInt(bar.style.width);
            if (width < 20) {
                bar.style.background = 'var(--accent-red)';
            } else if (width < 50) {
                bar.style.background = 'var(--accent-orange)';
            }
        });
    }

    const priceInput = document.getElementById('price');

if (priceInput) {
    priceInput.addEventListener('blur', function () {
        let value = this.value.trim();

        // Validar formato: hasta 3 dígitos antes del punto y máximo 2 decimales
        const decimalPattern = /^\d{1,3}(\.\d{1,2})?$/;

        let num = parseFloat(value);

        if (isNaN(num) || !decimalPattern.test(value)) {
            // Si no es número válido, limpiar
            this.value = "";
            return;
        }

        // Limitar rango de precio
        if (num < 0.99) num = 0.99;
        if (num > 999.99) num = 999.99;

        // Forzar dos decimales
        this.value = num.toFixed(2);
    });
}


    

        // Límite automático para el descuento (0 a 99)
        // Límite automático para el descuento (10% a 90%)
        // Descuento: mínimo 10, máximo 90, saltos de 5 en 5
    const discountInput = document.getElementById('discount');

if (discountInput) {
    
    // Bloqueo en tiempo real para que NO permita valores inválidos
    discountInput.addEventListener('input', function () {
        let value = this.value;

        // Quitar todo lo que NO sea número
        value = value.replace(/\D/g, "");

        // Convertir a número
        let num = parseInt(value);

        if (isNaN(num)) {
            this.value = "";
            return;
        }

        // Limitar rango mientras escribe
        if (num < 5) num = 5;
        if (num > 90) num = 90;

        this.value = num;
    });

    // Ajuste final al salir del input
    discountInput.addEventListener('blur', function () {
        let value = parseInt(this.value);

        if (isNaN(value)) return;

        // Redondear al múltiplo de 5 más cercano
        value = Math.round(value / 5) * 5;

        // límites
        if (value < 5) value = 5;
        if (value > 90) value = 90;

        this.value = value;
    });
}


const stockInput = document.getElementById('stock');

if (stockInput) {
    stockInput.addEventListener('blur', function () {
        let min = 0;
        let max = 99;
        let value = parseInt(this.value);

        if (isNaN(value)) value = min;

        if (value < min) value = min;
        if (value > max) value = max;

        this.value = value;
    });
}

});
