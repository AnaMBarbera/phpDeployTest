<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mi Web')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/blog.css') }}">
    <link rel="stylesheet" href="{{ asset('css/form.css') }}">
</head>
<body>

    <!-- Menú de navegación -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ url('/') }}" class="logo">
                <img src="{{ asset('img/logoosc3.png') }}" alt="Logo" class="logo-img">
                <span>DeployTest</span>
            </a>
            <ul class="nav-links">
                <li><a href="{{ url('/') }}">Inicio</a></li>
                <li><a href="{{ route('blog.index') }}">Blog</a></li>
                <li><a href="#">Login</a></li>
            </ul>
        </div>
    </nav>

    <!-- Contenido principal -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; {{ date('Y') }} DeployTest. Todos los derechos reservados.</p>
    </footer>

</body>
</html>
