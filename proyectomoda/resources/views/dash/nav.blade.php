<nav id="sidebar">
    <div class="sidebar-header">
        <h4 class="mb-0 fw-bold" style="color: #ffd9ea;">
            VIRTUALITY <span class="fw-light text-white">MALL</span>
        </h4>
        <small class="text-white-50">
            @auth
                Panel de {{ ucfirst(auth()->user()->rol) }}
            @endauth
        </small>
    </div>

    <div class="mt-4">
        <a href="{{ route('dashboard') }}" class="nav-link">
            <i class="fas fa-house"></i> Home
        </a>

        @auth
            @if(auth()->user()->rol === 'admin')
                <a href="{{ route('dashboard.clientes') }}" class="nav-link">
                    <i class="fas fa-user-tie"></i> Clientes / Emprendedores
                </a>

                <a href="{{ route('dashboard.tiendas') }}" class="nav-link">
                    <i class="fas fa-store"></i> Tiendas
                </a>

                <a href="{{ route('dashboard.users') }}" class="nav-link">
                    <i class="fas fa-users-cog"></i> Usuarios
                </a>
            @elseif(auth()->user()->rol === 'emprendedor')
                <a href="{{ route('dashboard.productos') }}" class="nav-link">
                    <i class="fas fa-box-open"></i> Productos
                </a>

                <a href="{{ route('dashboard.pedidos') }}" class="nav-link">
                    <i class="fas fa-shopping-cart"></i> Pedidos
                </a>

                <a href="{{ route('dashboard.pagos') }}" class="nav-link">
                    <i class="fas fa-credit-card"></i> Pagos
                </a>
            @elseif(auth()->user()->rol === 'cliente')
                <a href="{{ route('dashboard.compras') }}" class="nav-link">
                    <i class="fas fa-bag-shopping"></i> Compras
                </a>

                <a href="{{ route('dashboard.mis_pagos') }}" class="nav-link">
                    <i class="fas fa-wallet"></i> Pagos
                </a>
            @endif
        @endauth

        <hr class="mx-4 opacity-25">

        <a href="{{ route('home') }}" class="nav-link">
            <i class="fas fa-external-link-alt"></i> Ver sitio web
        </a>

        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button type="submit" class="nav-link text-warning w-100 text-start border-0 bg-transparent">
                <i class="fas fa-sign-out-alt"></i> Cerrar sesión
            </button>
        </form>
    </div>
</nav>