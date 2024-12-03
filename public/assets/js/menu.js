function guardarRutaActual(ruta) {
    localStorage.setItem('rutaActual', ruta);
}

function obtenerRutaActual() {
    return localStorage.getItem('rutaActual');
}

// Manejar el tema oscuro
let temaOscuro = localStorage.getItem('temaOscuro') === 'true';

function actualizarTema() {
    document.body.classList.toggle("tema-oscuro", temaOscuro);
    const toggleCirculo = document.querySelector(".toggle-circulo");
    if (toggleCirculo) {
        toggleCirculo.classList.toggle("activo", temaOscuro);
    }
}

function inicializarEventos() {
    const toggleMenu = document.getElementById("toggle-menu");
    const panelLateral = document.querySelector(".panel-lateral");
    const etiquetas = document.querySelectorAll(".etiqueta-menu");
    const toggleTema = document.querySelector(".toggle-tema");
    const contenidoPrincipal = document.querySelector(".contenido-principal");

    if (toggleMenu) {
        toggleMenu.addEventListener("click", () => {
            panelLateral.classList.toggle("panel-compacto");
            contenidoPrincipal.classList.toggle("contenido-expandido");
            etiquetas.forEach((etiqueta) => {
                etiqueta.classList.toggle("oculto");
            });
        });
    }

    if (toggleTema) {
        toggleTema.addEventListener("click", () => {
            temaOscuro = !temaOscuro;
            actualizarTema();
            localStorage.setItem('temaOscuro', temaOscuro);
        });
    }

    const enlacesNavegacion = document.querySelectorAll('.enlace-nav');
    enlacesNavegacion.forEach(enlace => {
        enlace.addEventListener('click', (e) => {
            const rutaClicada = enlace.getAttribute('href');
            guardarRutaActual(rutaClicada);
        });
    });

    actualizarTema();
}

document.addEventListener('DOMContentLoaded', () => {
    inicializarEventos();

    const rutaActual = window.location.pathname;
    const enlacesNavegacion = document.querySelectorAll('.enlace-nav');
    
    guardarRutaActual(rutaActual);
    
    enlacesNavegacion.forEach(enlace => {
        const rutaEnlace = enlace.getAttribute('href');
        if (rutaEnlace === rutaActual) {
            enlace.classList.add('ruta-activa');
        } else {
            enlace.classList.remove('ruta-activa');
        }
    });

    // Ocultar notificaciones después de 3 segundos
    setTimeout(() => {
        const notificaciones = document.querySelectorAll('.notificacion-alerta');
        notificaciones.forEach((notificacion) => {
            notificacion.style.display = 'none';
        });
    }, 3000);
});