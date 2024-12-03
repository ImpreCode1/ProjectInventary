<!DOCTYPE html>
<html lang="en">
<head>
    @notifyCss
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="cdrf-token" content="{{csrf_token()}}">
    <title>@yield('title', 'Inventario')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/menu.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <div id="dynamic-styles"></div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    {{-- <div id="app"> --}}
        <div class="barra-lateral">
            @include('partials.sidebar')
        </div>
        <main>
            {{-- <div class="loader" id="loader"></div> --}}
            {{-- <div id="contents"> --}}
            <div id="dynamic-content">
                @yield('content')  
            </div>
        </main>
    {{-- </div> --}}
   
    <div id="dynamic-styles"></div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        window.addEventListener('load', function() {
            document.body.style.opacity = 1;
            setTimeout(function() {
            document.getElementById('loader').style.display = 'none';
            }, 500);
        });
    </script>
    @notifyJs
    @include('notify::components.notify')

    <script src="{{ asset('assets/js/menus.js') }}"></script>
    <script src="{{ asset('assets/js/ajax-navigation.js') }}"></script>
    @stack('scripts')
</body>
</html>
