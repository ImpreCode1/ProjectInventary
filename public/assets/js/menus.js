// Funciones para manejar la sesión actual
function guardarSesionActual(ruta) {
    localStorage.setItem('sesionActual', ruta);
}

function obtenerSesionActual() {
    return localStorage.getItem('sesionActual');
}

// Manejar el modo oscuro
let modoOscuro = localStorage.getItem('modoOscuro') === 'true';

function actualizarModoOscuro() {
    document.body.classList.toggle("modo-oscuro", modoOscuro);
    const circulo = document.querySelector(".circulo");
    if (circulo) {
        circulo.classList.toggle("prendido", modoOscuro);
    }
}

function aplicarEventListeners() {
    const cloud = document.getElementById("cloud");
    const barraLateral = document.querySelector(".barra-lateral");
    const spans = document.querySelectorAll("span");
    const palanca = document.querySelector(".switch");
    const main = document.querySelector("main");

    if (cloud) {
        cloud.addEventListener("click", () => {
            barraLateral.classList.toggle("mini-barra-lateral");
            main.classList.toggle("min-main");
            spans.forEach((span) => {
                span.classList.toggle("oculto");
            });
        });
    }

    if (palanca) {
        palanca.addEventListener("click", () => {
            modoOscuro = !modoOscuro;
            actualizarModoOscuro();
            localStorage.setItem('modoOscuro', modoOscuro);
        });
    }

    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            const clickedPath = link.getAttribute('href');
            guardarSesionActual(clickedPath);
        });
    });

    actualizarModoOscuro();
}

document.addEventListener('DOMContentLoaded', () => {
    aplicarEventListeners();

    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');
    
    guardarSesionActual(currentPath);
    
    navLinks.forEach(link => {
        const linkPath = link.getAttribute('href');
        if (linkPath === currentPath) {
            link.classList.add('sesion-actual');
        } else {
            link.classList.remove('sesion-actual');
        }
    });

    setTimeout(() => {
        const notifications = document.querySelectorAll('.notify-alert');
        notifications.forEach((notification) => {
            notification.style.display = 'none';
        });
    }, 3000);
});

// Agregar este evento para manejar la navegación AJAX
document.addEventListener('contentLoaded', aplicarEventListeners);