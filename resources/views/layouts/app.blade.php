<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'UIO Paws')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos Solicitados */
        .navbar-custom {
            /* Color verde suave solicitado para la barra de navegación */
            background-color: #b0dbb2 !important;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }

        /* Estilos para los botones de acción principal (como el de Registrarse) */
        .btn-custom-blue {
            background-color: #1C8FE8; /* Azul fuerte para los botones de tu diseño */
            border-color: #1C8FE8;
            color: white;
            font-weight: 600;
        }
        .btn-custom-blue:hover {
            background-color: #1a7bd5;
            border-color: #1a7bd5;
        }

        /* Estilo para los botones de Iniciar Sesión (contorno) */
        .btn-outline-custom-blue {
            color: #1C8FE8;
            border-color: #1C8FE8;
        }
        .btn-outline-custom-blue:hover {
            background-color: #1C8FE8;
            color: white;
        }

        /* Estilo para los enlaces de Adopta/Voluntario/Donaciones */
        .navbar-nav .nav-link {
            color: #333333; /* Color de texto para buen contraste */
            font-weight: 500;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom"> {{-- APLICA AQUÍ LA CLASE CUSTOM --}}
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">🐾 UIO Paws</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">

                {{-- ENLACES DE NAVEGACIÓN CENTRALES (Adopta, Voluntario, Donaciones) --}}
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Adopta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Sé Voluntario</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Donaciones</a>
                    </li>
                </ul>

                {{-- ENLACES DE AUTENTICACIÓN A LA DERECHA --}}
                <ul class="navbar-nav ms-auto">
                    @if(Session::has('api_token'))
                        @if(Session::get('user_role') === 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.users.index') }}">Gestionar Usuarios</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">Mi Panel</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link">Cerrar Sesión</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item me-2">
                            {{-- Botón Iniciar Sesión con estilo outline azul --}}
                            <a class="btn btn-outline-custom-blue" href="{{ route('login') }}">Iniciar Sesión</a>
                        </li>
                        <li class="nav-item">
                            {{-- Botón Registrarse con estilo azul sólido --}}
                            <a class="btn btn-custom-blue" href="{{ route('register.form') }}">Registrarse</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-5">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
