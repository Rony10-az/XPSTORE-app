// ==== JS del perfil ====

// Previsualizar la imagen antes de guardarla
document.addEventListener("DOMContentLoaded", () => {
    const fileInput = document.querySelector(".file-input");
    const avatarImg = document.querySelector(".avatar-img");

    if (fileInput && avatarImg) {
        fileInput.addEventListener("change", function () {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = e => avatarImg.src = e.target.result;
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
});
