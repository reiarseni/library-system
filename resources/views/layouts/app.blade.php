<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca - Sistema de Gestión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --accent-color: #4895ef;
            --success-color: #4cc9f0;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: #333;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .form-control, .form-select {
            border-radius: 8px;
            padding: 0.6rem 1rem;
            border: 1px solid #e0e0e0;
            transition: all 0.3s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
        }

        .table {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        }

        .table thead th {
            background-color: #f8f9fa;
            border-bottom: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
        }

        .table tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }

        .badge {
            padding: 0.5em 0.8em;
            font-weight: 500;
            border-radius: 6px;
        }

        .badge.bg-success {
            background-color: var(--success-color) !important;
        }

        /* Login form */
        .login-card {
            max-width: 400px;
            margin: 0 auto;
            padding: 2rem;
        }

        .login-card .card-title {
            text-align: center;
            margin-bottom: 1.5rem;
            color: var(--primary-color);
            font-weight: 600;
        }

        .login-form .form-floating {
            margin-bottom: 1.5rem;
        }

        .login-icon {
            color: var(--primary-color);
            font-size: 1.2rem;
            margin-right: 0.5rem;
        }

        /* Pagination */
        .pagination-circle .page-link {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 3px;
            font-weight: 500;
            font-size: 0.9rem;
            color: var(--dark-color);
        }

        .pagination-circle .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            box-shadow: 0 4px 9px -4px var(--primary-color);
            color: white;
        }

        .pagination-circle .page-link:hover {
            background-color: #f8f9fa;
            border-color: #dee2e6;
        }

        .pagination-circle .page-item.active .page-link:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        /* Header */
        .app-header {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 1rem 0;
            margin-bottom: 2rem;
        }

        .app-title {
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
        }

        .app-subtitle {
            font-size: 0.9rem;
            color: #6c757d;
            margin: 0;
        }

        /* Estilos para el dropdown de usuario */
        .dropdown-item-form {
            padding: 0;
            margin: 0;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
        }

        .dropdown-item:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }
    </style>
    @livewireStyles
</head>
<body>
    <!-- Navbar unificado - solo visible para usuarios autenticados y no en la página de login -->
    @auth
    @if(!request()->routeIs('login'))
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top mb-4">
        <div class="container">
            <!-- Logo y nombre -->
            <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
                <i class="fas fa-book-open text-primary me-2 fs-4"></i>
                <div>
                    <h1 class="app-title mb-0">Biblioteca</h1>
                    <p class="app-subtitle mb-0">Sistema de Gestión de Libros</p>
                </div>
            </a>

            <!-- Botón hamburguesa para móviles -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Contenido del navbar -->
            <div class="collapse navbar-collapse" id="navbarMain">
                <!-- Enlaces de navegación -->
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item mx-3">
                        <a class="nav-link d-flex align-items-center {{ request()->routeIs('dashboard') ? 'active fw-bold text-primary' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fas fa-home me-2 {{ request()->routeIs('dashboard') ? 'text-primary' : 'text-muted' }}"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item mx-3">
                        <a class="nav-link d-flex align-items-center {{ request()->routeIs('books.search') ? 'active fw-bold text-primary' : '' }}" href="{{ route('books.search') }}">
                            <i class="fas fa-search me-2 {{ request()->routeIs('books.search') ? 'text-primary' : 'text-muted' }}"></i>
                            <span>Buscar Libros</span>
                        </a>
                    </li>
                    @if(Auth::check() && Auth::user()->role === 'admin')
                    <li class="nav-item mx-3">
                        <a class="nav-link d-flex align-items-center" href="/admin">
                            <i class="fas fa-cog me-2 text-muted"></i>
                            <span>Admin</span>
                        </a>
                    </li>
                    @endif
                </ul>

                <!-- Menú de usuario -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-2 text-primary"></i>
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="dropdown-item-form">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>Cerrar sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @endif
    @endauth

    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer class="py-4 mt-5">
        <div class="container text-center text-muted">
            <p>&copy; {{ date('Y') }} Biblioteca - Sistema de Gestión</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>
</html>
