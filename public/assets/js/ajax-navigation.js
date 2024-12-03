// document.addEventListener('DOMContentLoaded', () => {
//     inicializarNavegacionAjax();
// });

// function inicializarNavegacionAjax() {
//     const enlaces = document.querySelectorAll('.nav-link');
//     enlaces.forEach(enlace => {
//         enlace.addEventListener('click', manejarClicEnlace);
//     });

//     window.addEventListener('popstate', manejarCambioHistorial);
// }

// async function manejarClicEnlace(e) {
//     e.preventDefault();
//     const url = this.getAttribute('href');
//     await cargarContenido(url);
// }

// async function cargarContenido(url) {
//     try {
//         mostrarLoader();
//         const respuesta = await fetch(url, {
//             headers: {
//                 'X-Requested-With': 'XMLHttpRequest'
//             }
//         });
//         if (!respuesta.ok) throw new Error('Error al cargar el contenido');
//         const contenido = await respuesta.text();
        
//         document.getElementById('dynamic-content').innerHTML = contenido;
        
//         history.pushState({url: url}, '', url);
        
//         actualizarMenuActivo(url);
//         ejecutarScripts();
//         ocultarLoader();
//     } catch (error) {
//         console.error('Error:', error);
//         ocultarLoader();
//     }
// }

// function manejarCambioHistorial(event) {
//     if (event.state && event.state.url) {
//         cargarContenido(event.state.url);
//     }
// }

// function actualizarMenuActivo(url) {
//     const enlaces = document.querySelectorAll('.nav-link');
//     enlaces.forEach(enlace => {
//         if (enlace.getAttribute('href') === url) {
//             enlace.classList.add('active');
//         } else {
//             enlace.classList.remove('active');
//         }
//     });
// }

// function ejecutarScripts() {
//     const scripts = document.getElementById('dynamic-content').getElementsByTagName('script');
//     for (let script of scripts) {
//         eval(script.innerHTML);
//     }
// }

// function mostrarLoader() {
//     document.getElementById('loader').style.display = 'flex';
// }

// function ocultarLoader() {
//     document.getElementById('loader').style.display = 'none';
// }