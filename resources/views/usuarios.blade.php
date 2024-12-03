@extends('layout')

@section('title', 'Inventario')

@section('content')
    <link rel="icon" href="/assets/Recursos/icoprin.ico">

    <div id="dynamic-content">
        <link rel="stylesheet" href="/assets/css/usuarios.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
            rel="stylesheet">
        <header>
            <div class="top-container">
                <div class="top-left">

                    <h1
                        style="color: #ffffff; font-size: 2.5rem; font-family: 'Playfair Display', sans-serif; text; text-align:center; ">
                        Usuarios</h1>
                </div>
            </div>
        </header>

        <div>
            <div class="container">
                <div class="text-content">
                    <h2>Historial de Usuarios Registrados</h2>
                    <p>Bienvenido al apartado donde puedes vizualizar el historial de usuarios registrados en nuestra
                        página.</p>
                </div>
            </div>
        </div>


        <div class="container-input">
            <input type="text" placeholder="Buscar" name="text" class="input">
            <svg fill="#000000" width="20px" height="20px" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M790.588 1468.235c-373.722 0-677.647-303.924-677.647-677.647 0-373.722 303.925-677.647 677.647-677.647 373.723 0 677.647 303.925 677.647 677.647 0 373.723-303.924 677.647-677.647 677.647Zm596.781-160.715c120.396-138.692 193.807-319.285 193.807-516.932C1581.176 354.748 1226.428 0 790.588 0S0 354.748 0 790.588s354.748 790.588 790.588 790.588c197.647 0 378.24-73.411 516.932-193.807l516.028 516.142 79.963-79.963-516.142-516.028Z"
                    fill-rule="evenodd"></path>
            </svg>
        </div>


        <div class="container-card">
            @foreach ($usuarios as $usuario)
                <div class="card">
                    <div class="img-container">
                        <div>
                            <img class="img" style="center/cover" src="{{ asset($usuario->imagen) }}">
                        </div>
                    </div>
                    <div class="info">
                        <h3>{{ $usuario->nombres }} {{ $usuario->apellidos }}</h3>
                        <p>{{ $usuario->rol }}</p>
                    </div>

                    <form method="POST" action="{{ route('usuario.destroy', $usuario->id) }}" class="btn-eliminar">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="button">
                            <svg viewBox="0 0 448 512" class="svgIcon">
                                <path
                                    d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z">
                                </path>
                            </svg>
                        </button>
                    </form>
                </div>
                <div id="no-results" style="display:none; place-items:center; margin:auto; text-align:center; width:100%;">
                    <p>No se encontraron resultados para tu búsqueda.</p>
                </div>
            @endforeach

        </div>
    </div>
@endsection


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function initializeUsuariosPage() {
            const eliminarBotones = document.querySelectorAll('.btn-eliminar');
            const inputField = document.querySelector('.input');
            const cards = document.querySelectorAll('.card');
            const noResultsMessage = document.getElementById('no-results');

            eliminarBotones.forEach(function(boton) {
                boton.addEventListener('submit', function(event) {
                    event.preventDefault();

                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: "custom-confirm-yes",
                            cancelButton: "custom-confirm-cancel"
                        },
                        buttonsStyling: false
                    });
                    swalWithBootstrapButtons.fire({
                        title: "Estás seguro?",
                        text: "No podrás revertir esto!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Si, eliminar!",
                        cancelButtonText: "No, cancelar!",
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            boton.submit();
                            swalWithBootstrapButtons.fire({
                                title: "Eliminado!",
                                text: "Usuario eliminado.",
                                icon: "success"
                            });
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            swalWithBootstrapButtons.fire({
                                title: "Cancelado",
                                icon: "error"
                            });
                        }
                    });
                });
            });

            if (inputField) {
                inputField.addEventListener('input', function() {
                    const searchTerm = inputField.value.trim().toLowerCase();
                    let resultsFound = false;

                    cards.forEach(function(card) {
                        const userName = card.querySelector('h3').textContent.toLowerCase();

                        if (userName.includes(searchTerm)) {
                            card.classList.remove('hidden');
                            resultsFound = true;
                        } else {
                            card.classList.add('hidden');
                        }
                    });

                    if (resultsFound) {
                        noResultsMessage.style.display = 'none';
                    } else {
                        noResultsMessage.style.display = 'block';
                    }
                });
            }
        }

        document.addEventListener('DOMContentLoaded', initializeUsuariosPage);
    </script>
@endpush
