// JavaScript para formularios de creación
document.addEventListener('DOMContentLoaded', function() {
    console.log('Create form loaded');

    // Validaciones adicionales para formularios de creación
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            // Aquí puedes agregar validaciones custom antes del submit
        });
    });
});
