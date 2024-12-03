@extends('layout2')

@section('title', 'Inventario')


@section('content')
    <link rel="icon" href="/assets/Recursos/icoprin.ico">

    <div id="dynamics-contents">
        <link rel="stylesheet" href="/assets/css/verproducto.css">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
            rel="stylesheet">
        <header>
            <div class="top-container">
                <h1 style="color: #fffffff; font-size: 2rem; font-family: 'Playfair Display', sans-serif;">Ver Productos
                </h1>
            </div>
        </header>

        {{-- modal para los movimientos de producto --}}

        <div id="productModal" class="modal" style="display: none;">
            <div class="modal-content">
                <span class="close">&times;</span>
                <div id="modalBody"></div>
            </div>
        </div>

        {{-- <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Título del Modal</h2>
          
        </div>
        </div> --}}

        <div>
            <div class="container">
                <div class="text-content">
                    <h2>Registro de Uso de Productos</h2>
                    <p>Este apartado permite a los usuarios visualizar los productos disponibles y registrar su uso para que
                        el
                        administrador pueda llevar un informe detallado.
                    </p>
                </div>


                <div class="inputBox_container">
                    <svg class="search_icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" alt="search icon">
                        <path
                            d="M46.599 46.599a4.498 4.498 0 0 1-6.363 0l-7.941-7.941C29.028 40.749 25.167 42 21 42 9.402 42 0 32.598 0 21S9.402 0 21 0s21 9.402 21 21c0 4.167-1.251 8.028-3.342 11.295l7.941 7.941a4.498 4.498 0 0 1 0 6.363zM21 6C12.717 6 6 12.714 6 21s6.717 15 15 15c8.286 0 15-6.714 15-15S29.286 6 21 6z">
                        </path>
                    </svg>
                    <input class="inputBox" id="inputBox" placeholder="Buscar por producto">
                </div>
            </div>




            {{-- diseño para ver los productos --}}
            {{-- <p style="align-content: center; color:#5ca117;">Productos Disponibles</p> --}}

            <div class="container-card">
                @if ($productos->isNotEmpty())
                    @foreach ($productos as $producs)
                        <div class="card">
                            <div class="img-container">
                                <img class="img" src="{{ $producs->imagen }}" alt="{{ $producs->nombre }}">
                            </div>
                            <h3 class="product-title">{{ $producs->nombre }}</h3>
                            <div class="content">
                                <h3 class="title">{{ $producs->nombre }}</h3>
                                <p class="description">{{ $producs->descripcion }}</p>
                                <button type="button" class="btn-use" data-product-id="{{ $producs->id }}">
                                    Ver Detalles
                                    <ion-icon name="eyedrop-outline"></ion-icon>
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="no-products-container">
                        <div class="no-products-icon">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <h2 class="no-products-title">No hay productos disponibles para usar!</h2>
                        <p class="no-products-description">
                            Parece que aún no se han agregado productos. ¡Pídele al administrador
                            añadir productos para verlos aquí!
                        </p>
                    </div>
                @endif
            </div>

            <div id="no-results" style="display: none;">
                <p>No se encontraron resultados de búsqueda.</p>
            </div>

        </div>
    </div>
    {{-- <link rel="stylesheet" href="/assets/css/categorias.css"> --}}

@endsection


@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const inputBox = document.querySelector('#inputBox');
        const cards = document.querySelectorAll('.card');
        const noResultsMessage = document.getElementById('no-results');

        inputBox.addEventListener('input', function() {
            const search = this.value.trim().toLowerCase();
            let resultsFoud = false;

            cards.forEach(function(card) {
                const title = card.querySelector('.product-title').textContent.toLowerCase();

                if (title.includes(search)) {
                    // card.classList.remove('hidden');
                    card.style.display = 'block';
                    resultsFoud = true;
                } else {
                    // card.classList.add('hidden');
                    card.style.display = 'none';
                }
            });

            if (resultsFoud) {
                noResultsMessage.style.display = 'none';
            } else {
                noResultsMessage.style.display = 'block';
            }
        });

        $(document).ready(function() {

            $(document).on('click', '.btn-use', function() {
                var productId = $(this).data('product-id');
                $.ajax({
                    url: '/formulario/' + productId,
                    type: 'GET',
                    success: function(response) {

                        var modalId = 'productModal_' + productId;
                        var modalHtml = '<div id="' + modalId + '" class="modal">' +
                            '<div class="modal-content">' +
                            '<span class="close">&times;</span>' +
                            '<div class="modalBody">' + response + '</div>' +
                            '</div>' +
                            '</div>';

                        // Añadir el modal al body
                        $('body').append(modalHtml);

                        // Mostrar el modal
                        $('#' + modalId).show();

                        // Manejar el cierre del modal
                        $('#' + modalId + ' .close').click(function() {
                            $('#' + modalId).remove();
                        });

                        // Cerrar el modal si se hace clic fuera de él
                        // $(window).click(function(event) {
                        //     if (event.target.id === modalId) {
                        //         $('#' + modalId).remove();
                        //     }
                        // });
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endpush
