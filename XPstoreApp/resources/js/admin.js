// resources/js/admin.js
document.addEventListener('DOMContentLoaded', function () {
    console.log('Admin CRUD cargado');

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

    updateStockBars();
});