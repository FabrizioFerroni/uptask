const mobileMenu = document.querySelector('#mobile-menu');
const mobileCerrar = document.querySelector('#mobile-cerrar');
const sidebar = document.querySelector('.sidebar');
if (mobileMenu) {
    mobileMenu.addEventListener('click', () => {
        sidebar.classList.add('mostrar');
    })
}

if (mobileCerrar) {
    mobileCerrar.addEventListener('click', () => {
        sidebar.classList.add('ocultar');
        setTimeout(() => {
            sidebar.classList.remove('mostrar');
            sidebar.classList.remove('ocultar');
        }, 1000);

    })
}

// Elimina la clase de mostrar, en un tamaño de tablet y mayores
window.addEventListener('resize', () => {
    const anchoPantalla = document.body.clientWidth;
    if (anchoPantalla >= 768) {
        sidebar.classList.remove('mostrar');
    }
})