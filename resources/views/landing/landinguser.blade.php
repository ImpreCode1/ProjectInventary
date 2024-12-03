<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Impresistem</title>
    <link rel="stylesheet" href="/assets/css/landing.css">
    <link rel="icon" href="/assets/Recursos/icoprin.ico">

</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <a href="#" style="Color:#A46935">Inventario</a>
            </div>
            <ul>
                <li><a style="Color:#5A483D"></a></li>
                <li><a style="Color:#5A483D"></a></li>
                <li><a style="Color:#5A483D"></a></li>
                <li><a style="Color:#5A483D"></a></li>
            </ul>
            <div class="user-profile">
                <img src="{{asset($userImagen)}}" alt="Profile Picture"
                    class="profile-picture">
                <span class="username">{{$userNombres ?? ''}} {{$userApellidos ?? ''}}</span>
            </div>
            <div>
                <a class="Btn" href="{{route('logouts')}}">
                    <div class="sign"><svg viewBox="0 0 512 512"><path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path></svg></div>
                    <div class="text">Salir</div>
                </a>                  
            </div>
        </nav>
    </header>
    <main>
        <section class="hero">
            <div class="hero-content">
                <h1 style="color:rgb(247, 155, 75) ">Bienvenido a Nuestro Sistema de Inventario de Productos</h1>
                <p>Explora y gestiona eficientemente nuestro catalogo de productos con nuestra intuitiva plataforma
                    de inventario. Aqui encontraras todas las herramientas necesarias para mantener un control preciso
                    y actualizado, optimizando asi tu tiempo y recursos.
                </p>
                <a  href="{{ route('verproductos') }}" class="btn">Comenzar</a>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <div>
                <p class="footer-text">
                    &copy; 2024 <span class="footer-logo">Impresistem</span>
                </p>
                <p class="footer-text">
                    Reservados todos los derechos.
                </p>
                <p class="footer-text">
                    Diseñado y desarrollado por <span class="designer-name">Kevin Jhoe Gomez</span>
                </p>
            </div>
        </div>
    </footer>
</body>

</html>
