<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'UIO Paws - Adopción de Animales')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Estilos personalizados -->
    <style>
        body { background-color: #f4f7f6; }
        .navbar { box-shadow: 0 2px 4px rgba(0,0,0,.08); }
        .card { border: none; box-shadow: 0 1px 3px rgba(0,0,0,.12), 0 1px 2px rgba(0,0,0,.24); }
        .btn-primary { background-color: #005A8D; border-color: #005A8D; }
        .btn-primary:hover { background-color: #004B74; border-color: #004B74; }
    </style>
</head>
<body>

    @include('layouts.partials.navbar')

    <main class="container my-4 my-md-5">
        @include('layouts.partials.messages')
        @yield('content')
    </main>

    <footer class="text-center text-muted py-4 mt-auto">
        <p>&copy; {{ date('Y') }} UIO Paws. Todos los derechos reservados.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>