<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BibliotecaHub')</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f3f4f6;
            color: #1f2937;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            box-shadow: 0 4px 15px rgba(30, 58, 138, 0.15);
            padding: 1rem 0;
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: -0.5px;
            font-size: 1.4rem;
            color: #ffffff !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .nav-link {
            font-weight: 500;
            color: rgba(255, 255, 255, 0.85) !important;
            transition: all 0.25s ease;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .nav-link:hover, .nav-link.active {
            color: #ffffff !important;
            background-color: rgba(255, 255, 255, 0.15);
            transform: translateY(-1px);
        }

        .card {
            border: none;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-header {
            background-color: transparent;
            border-bottom: 1px solid #f3f4f6;
            padding: 1.5rem;
            font-weight: 600;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 10px;
            font-weight: 500;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2);
            transition: all 0.25s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            box-shadow: 0 6px 15px rgba(37, 99, 235, 0.3);
            transform: translateY(-2px);
        }
        .btn-outline-secondary {
            border-radius: 10px;
            padding: 0.6rem 1.5rem;
        }

        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
        }
        .table {
            margin-bottom: 0;
        }
        .table th {
            background-color: #f8fafc;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            border-bottom-width: 1px;
            padding: 1rem;
        }
        .table td {
            padding: 1.2rem 1rem;
            vertical-align: middle;
            border-bottom-color: #f1f5f9;
        }
        .table tbody tr:hover {
            background-color: #f8fafc;
        }

        .stock-badge {
            font-weight: 600;
            padding: 0.4rem 0.8rem;
            border-radius: 30px;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .stock-in {
            background-color: #d1fae5;
            color: #065f46;
        }
        .stock-out {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .user-dropdown .dropdown-toggle::after {
            display: none;
        }
        .user-dropdown .dropdown-menu {
            border-radius: 12px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 0.5rem;
        }
        .user-dropdown .dropdown-item {
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 500;
        }
        .user-dropdown .dropdown-item:hover {
            background-color: #f3f4f6;
        }

        footer {
            margin-top: auto;
            background-color: #ffffff;
            border-top: 1px solid #e5e7eb;
            padding: 1.5rem 0;
            color: #6b7280;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('books.index') }}">
                <i class="fa-solid fa-book-bookmark"></i> BibliotecaHub
            </a>

            @auth
            <div class="d-flex align-items-center gap-2 order-lg-last ms-auto ms-lg-3">
                <span class="text-white small">
                    <i class="fa-solid fa-circle-user"></i>
                    <span class="d-none d-md-inline ms-1">{{ auth()->user()->name }}</span>
                </span>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm rounded-3 border-0 px-2" title="Cerrar sesión">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>
            @else
            <div class="ms-auto">
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm rounded-3">
                    <i class="fa-solid fa-right-to-bracket me-1"></i> Iniciar sesión
                </a>
            </div>
            @endauth

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}" href="{{ route('books.index') }}">
                            <i class="fa-solid fa-list-check"></i> Control de Libros
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('movements.*') ? 'active' : '' }}" href="{{ route('movements.index') }}">
                            <i class="fa-solid fa-right-left"></i> Entradas y Salidas
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 p-3 mb-4" role="alert">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-circle-check text-success fs-4"></i>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 p-3 mb-4" role="alert">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation text-danger fs-4"></i>
                    <div>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @isset($header)
            <div class="mb-4">
                <div class="d-flex align-items-center gap-3">
                    {{ $header }}
                </div>
            </div>
        @endisset

        {{ $slot ?? '' }}
        @yield('content')
    </div>

    <footer>
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} BibliotecaHub - Sistema de Gestión de Existencias. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>