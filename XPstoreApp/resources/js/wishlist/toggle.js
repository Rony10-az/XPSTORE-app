console.log("Wishlist JS cargado correctamente");

document.addEventListener("DOMContentLoaded", () => {

    document.querySelectorAll(".wishlist-btn").forEach(btn => {
        btn.addEventListener("click", async (e) => {
            e.preventDefault();
            e.stopPropagation();

            let id = btn.dataset.id;
            let type = btn.dataset.type;

            let response = await fetch("/wishlist/toggle", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector("meta[name='csrf-token']").content
                },
                body: JSON.stringify({ item_id: id, item_type: type })
            });

            let result = await response.json();

            if (result.status === "added") {
                btn.classList.add("active");
                showToast("Agregado a tu wishlist");
            }

            if (result.status === "removed") {
                btn.classList.remove("active");
                showToast("Eliminado de tu wishlist");
            }
        });
    });

});


