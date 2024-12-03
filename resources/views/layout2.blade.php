<!DOCTYPE html>
<html lang="es">

<head>
    @notifyCss
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/barra-lateral.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <link rel="icon" href="/assets/Recursos/icoprin.ico">

    <style>
    .loader{
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        display: flex;
        justify-content: center;
        background-color: #f8f9fa;
        z-index:9999;
    }

    .loader::after{
        content: "";
        width: 50px;
        height: 50px;
        border: 10px solid #dddddd;
        border-top-color: #7449f5;
        border-radius: 50%;
        animation: loading 1s ease infinite;
    }

    @keyframes loading {
        from { transform: rotate(0turn) }
        to { transform: rotate(1turn) }
    }
    body{
        /* visibility: hidden; */
        opacity: 0;
        transition: opacity 0.3s ease;
    }
</style>
</head>

<body>
    <div class="panel-lateral">
        @include('partials.sidebar2')
    </div>

    <main class="contenido-principal">
        <div id="contenido-dinamico">
        @yield('content')
        </div>
    </main>

    {{-- <script src="{{ asset('assets/js/panel-control.js') }}"></script> --}}
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    @notifyJs
    @include('notify::components.notify')
    
    <script src="{{ asset('assets/js/menu.js') }}"></script>
    @stack('scripts')
    <script>
        window.addEventListener('load', function() {
            document.body.style.opacity = 1;
            setTimeout(function() {
            document.getElementById('loader').style.display = 'none';
            }, 500);
        });
    </script>
</body>

</html>