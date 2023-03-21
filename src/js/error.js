const listaCerrar = document.querySelectorAll(".cerrar");
Array.from(listaCerrar).forEach((cerrar) => {
    cerrar.addEventListener("click", () => {
        const alerta = cerrar.parentNode; //o pudo ser cerrar.closest('.alerta');
        alerta.style.display = "none";
    });
});