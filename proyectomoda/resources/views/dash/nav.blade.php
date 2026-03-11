<nav id="sidebar">
    <div class="sidebar-header">
        <h4 class="mb-0 fw-bold" style="color: #ffd9ea;">
            VIRTUALITY <span class="fw-light text-white">MALL</span>
        </h4>
        <small class="text-white-50">Panel de administración</small>
    </div>

    <div class="mt-4">
        <a href="{{ route('dashboard') }}" class="nav-link active">
            <i class="fas fa-chart-line"></i> Dashboard
        </a>

        <a href="{{ route('dashboard.users') }}" class="nav-link">
            <i class="fas fa-users"></i> Usuarios
        </a>

        <a href="#" class="nav-link">
            <i class="fas fa-store"></i> Tiendas
        </a>

        <a href="#" class="nav-link">
            <i class="fas fa-box-open"></i> Productos
        </a>

        <a href="#" class="nav-link">
            <i class="fas fa-shopping-cart"></i> Órdenes
        </a>

        <a href="#" class="nav-link">
            <i class="fas fa-credit-card"></i> Pagos
        </a>

        <hr class="mx-4 opacity-25">

        <a href="{{ route('home') }}" class="nav-link">
            <i class="fas fa-external-link-alt"></i> Ver sitio web
        </a>

        <a href="#" class="nav-link text-warning mt-4">
            <i class="fas fa-sign-out-alt"></i> Cerrar sesión
        </a>
    </div>
</nav>