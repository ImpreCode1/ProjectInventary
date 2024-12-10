@extends('layout')

@section('title', 'Inventario')

@section('content')
    <link rel="icon" href="/assets/Recursos/icoprin.ico">

    <div id="dynamic-content">

        <link rel="stylesheet" href="/assets/css/stock.css">
        <link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/r-2.4.1/datatables.min.css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
            rel="stylesheet">

        <div class="container-fluid py-4">
            <header>
                <div class="top-container">
                    <div class="top-left">
                        <h1 style="color: #ffffff; font-size:2.5rem; font-family:'Playfair Display', serif;">Stock Productos
                        </h1>
                    </div>
                </div>
            </header>

            <div class="row-justify-content-center">
                <form class="form" action="{{ route('stock.exportproducto')}}">
                    <button class="download-button" type="submit">
                        <div class="docs"><svg class="css-i6dzq1" stroke-linejoin="round" stroke-linecap="round"
                                fill="none" stroke-width="2" stroke="currentColor" height="20" width="20"
                                viewBox="0 0 24 24">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line y2="13" x2="8" y1="13" x1="16"></line>
                                <line y2="17" x2="8" y1="17" x1="16"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg> Descargar Reporte</div>

                        <div class="download">
                            <svg class="css-i6dzq1" stroke-linejoin="round" stroke-linecap="round" fill="none"
                                stroke-width="2" stroke="currentColor" height="24" width="24" viewBox="0 0 24 24">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line y2="3" x2="12" y1="15" x1="12"></line>
                            </svg>
                        </div>
                    </button>
                </form>

                <div class="col-12 col-lg-10">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table custom-table">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Stock</th>
                                            <th>Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($producto as $prostock)
                                            <tr>
                                                <td>{{ $prostock->nombre }}</td>
                                                @if ($prostock->UnidadMedida->es_compuesta === 1 && $prostock->cantidad_unidad_compuesta !== null)
                                                       <td>{{ formatNumber($prostock->cantidad) }}
                                                        {{ $prostock->UnidadMedida->nombre }} <a style="color: hsl(108, 31%, 52%)">Cantidad disponible: </a>{{formatNumber($prostock->cantidad_total)}} unidade(s)</td>
                                                @else
                                                        <td>{{ formatNumber($prostock->cantidad) }}
                                                        {{ $prostock->UnidadMedida->nombre }}
                                                @endif
                                                {{-- <td>{{ $prostock->updated_at }}</td> --}}
                                                <td>{{ $prostock->updated_at->format('Y-m-d') }}</td>

                                             </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.4/r-2.4.1/datatables.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json',
                    paginate: {
                        previous: '◄',
                        next: '►'
                    }
                },
                "dom": '<"top"lf>rt<"bottom"ip><"clear">',
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Todos"]
                ],
                "pageLength": 10,
                "pagingType": "simple"
            });


            $('.download-button').on('click', function(e) {
            e.preventDefault();

            // var params = table.ajax.params();
            // params.export = true;
            // window.location.href = "{{ route('reportes.export') }}?" + $.param(params);

            var params = {
                search: table.search(),
                order: table.order().map(function(order){
                    return {
                        colum: order[0],
                        dir: order[1]
                    }
                }),

                length: table.page.len(),
                start: table.page.info().start,
                export: true
            };

            window.location.href = "{{ route('stock.exportproducto') }}?" + $.param(params);

        });

        });
    </script>
@endpush
