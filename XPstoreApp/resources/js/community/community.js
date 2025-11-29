const btn = document.getElementById("openCommunity");
const panel = document.getElementById("communityPanel");

if (btn && panel) {
    btn.addEventListener("click", () => {
        panel.classList.toggle("active");
    });
}
