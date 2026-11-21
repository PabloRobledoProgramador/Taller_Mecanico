function flipCard() {
    const card = document.getElementById("authCard");
    card.classList.toggle("flipped");
}

function togglePassword(id, button) {
    const input = document.getElementById(id);
    const icon = button.querySelector("i");
    const show = input.type === "password";

    input.type = show ? "text" : "password";
    icon.classList.toggle("fa-eye", !show);
    icon.classList.toggle("fa-eye-slash", show);
}

// Vite carga el archivo como módulo, así que hay que exponerlas
// para que los onclick="..." del HTML las encuentren.
window.flipCard = flipCard;
window.togglePassword = togglePassword;
