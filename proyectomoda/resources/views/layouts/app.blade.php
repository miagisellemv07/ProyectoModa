<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Virtuality Emprendedores Mall</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <style>
        :root{
            --rosa-suave: #f8d9e8;
            --rosa-medio: #e9a9c4;
            --lila-suave: #d9c7f2;
            --morado-suave: #9b7cc3;
            --azul-pastel: #cfe7ff;
            --azul-medio: #9ecbf3;
            --crema: #fff9fc;
            --texto: #4f4459;
            --oscuro: #5d4b69;
            --blanco: #ffffff;
            --sombra: 0 10px 25px rgba(0,0,0,.08);
        }

        body{
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #fff2f8 0%, #f2ebff 50%, #ebf6ff 100%);
            color: var(--texto);
            min-height: 100vh;
        }

        .navbar-custom{
            background: linear-gradient(90deg, var(--rosa-suave), var(--lila-suave), var(--azul-pastel));
            box-shadow: var(--sombra);
        }

        .navbar-brand{
            font-size: 1.7rem;
            font-weight: 800;
            color: var(--oscuro) !important;
            letter-spacing: 1px;
        }

        .navbar-brand span{
            color: #d978a6;
        }

        .nav-link{
            color: #5b4b67 !important;
            font-weight: 600;
        }

        .nav-link:hover{
            color: #c86f9b !important;
        }

        .dropdown-menu{
            border: none;
            border-radius: 16px;
            box-shadow: var(--sombra);
        }

        .dropdown-item:active{
            background-color: #f3e9fb;
            color: var(--oscuro);
        }

        main{
            min-height: calc(100vh - 76px);
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-custom shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Virtuality <span>Mall</span>
                </a>

                <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars" style="color: #5d4b69;"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side -->
                    <ul class="navbar-nav me-auto"></ul>

                    <!-- Right Side -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown"
                                   class="nav-link dropdown-toggle"
                                   href="#"
                                   role="button"
                                   data-bs-toggle="dropdown"
                                   aria-haspopup="true"
                                   aria-expanded="false"
                                   v-pre>
                                    {{ Auth::user()->nombre ?? Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                                        <i class="fas fa-chart-line me-2"></i>Dashboard
                                    </a>

                                    <a class="dropdown-item" href="{{ url('/') }}">
                                        <i class="fas fa-globe me-2"></i>Ir al sitio
                                    </a>

                                    <hr class="dropdown-divider">

                                    <a class="dropdown-item"
                                       href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i>Cerrar sesión
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>