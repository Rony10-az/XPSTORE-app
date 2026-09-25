document.addEventListener("DOMContentLoaded", () => {

    // Ocultar alerta después de 2.5s
    const alert = document.getElementById("cartAlert");
    if (alert) {
        setTimeout(() => {
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 400);
        }, 2500);
    }

    // Contador dinámico del carrito en el header
    function updateCartCount() {
        const count = document.querySelectorAll("#cartTableBody tr").length;
        const cartCountEl = document.querySelector(".cart-count");

        if (cartCountEl) cartCountEl.textContent = count;
    }
    updateCartCount();


    // Incremento y decremento de cantidades
    document.querySelectorAll(".increase").forEach(btn => {
        btn.addEventListener("click", (e) => {
            const row = e.target.closest("tr");
            const qtyEl = row.querySelector(".qty-value");
            let qty = parseInt(qtyEl.textContent);

            qty++;
            qtyEl.textContent = qty;

            updateSubtotal(row);
            updateTotal();
        });
    });

    document.querySelectorAll(".decrease").forEach(btn => {
        btn.addEventListener("click", (e) => {
            const row = e.target.closest("tr");
            const qtyEl = row.querySelector(".qty-value");
            let qty = parseInt(qtyEl.textContent);

            if (qty > 1) {
                qty--;
                qtyEl.textContent = qty;

                updateSubtotal(row);
                updateTotal();
            }
        });
    });

    // Recalcular subtotal por fila
    function updateSubtotal(row) {
        const price = parseFloat(row.children[1].textContent.replace("$", ""));
        const qty = parseInt(row.querySelector(".qty-value").textContent);
        const subtotal = (price * qty).toFixed(2);

        row.querySelector(".subtotal").textContent = "$" + subtotal;
    }

    // Recalcular total general
    function updateTotal() {
        let total = 0;

        document.querySelectorAll("#cartTableBody tr").forEach(row => {
            const sub = parseFloat(row.querySelector(".subtotal").textContent.replace("$", ""));
            total += sub;
        });

        document.getElementById("cartTotal").textContent = "$" + total.toFixed(2);
    }
});
