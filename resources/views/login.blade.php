<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/assets/css/login.css">
    <script src="/assets/js/login.js"></script>
    <title>Login</title>
    <link rel="icon" href="/assets/Recursos/icoprin.ico">
</head>
<body>
    <div class="container">
        <div class="left">
        </div>
        <div class="right">
            <div class="form-container">
                <h1>Bienvenido de nuevo!</h1>
                <p>Por favor, ingresa tus credenciales para acceder y gestionar nuestro inventario de manera eficiente.
                </p>
                <form action="{{ route('login.verify') }}" method="POST">
                    @csrf
                    <div class="form-inp">
                        <input placeholder="Ingrese su email" name="email" id="email" type="email"
                            value="{{ old('email', '') }}" style="color: black">
                        @if ($errors->has('email'))
                            <small class="form-e">
                                <strong>{{ $errors->first('email') }}</strong>
                            </small>
                        @endif
                    </div>
                    <div class="form-inp">
                        <input placeholder="Ingrese su contraseña" name="password" id="password-input" type="password"
                            value="{{ old('password', '') }}" style="color: black">
                        <span class="password-toggle-icon" onclick="togglePasswordVisibility()">&#128065;</span>

                        @if ($errors->has('password'))
                            <small class="form-e">
                                <strong>{{ $errors->first('password') }}</strong>
                            </small>
                        @endif
                    </div>
                    <br>
                    <button type="submit">Iniciar sesión</button>
                    @error('invalid_credentials')
                        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: '¡Ups!',
                                text: '{{ $message }}',
                                background: '#fff no-repeat 100% 100%',
                                backdrop: ` rgba(0,0,123,0.4) left top no-repeat `,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Intentar de nuevo',
                                confirmButtonTextColor: '#fff'
                            })
                        </script>
                    @enderror
                </form>
               
            </div>
        </div>


        
    </div>
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password-input');
            const isPasswordVisible = passwordInput.type === 'text';
            passwordInput.type = isPasswordVisible ? 'password' : 'text';
        }

        function dismissAlert(element) {
            const alert = element.closest('.alert');
            alert.classList.add('fade-out');
            setTimeout(() => {
                alert.remove();
            }, 300);
        }
    </script>
</body>

</html>
