@extends('dash.main')

@section('contenido')

<div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-3">
    <div>
        <h2 class="fw-bold m-0">
            Bienvenido,
            @auth
                {{ auth()->user()->nombre }}
            @endauth
        </h2>
        <p class="text-muted m-0">
            Dashboard principal del sistema Virtuality Mall
        </p>
    </div>

    <div class="text-muted small">
        @auth
            Rol actual: <strong>{{ ucfirst(auth()->user()->rol) }}</strong>
        @endauth
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon bg-accent-soft">
                <i class="fas fa-user"></i>
            </div>
            <div class="text-muted small fw-medium">Usuario autenticado</div>
            <div class="h4 fw-bold mt-1">
                @auth
                    {{ auth()->user()->nombre }} {{ auth()->user()->apellido }}
                @endauth
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon bg-blue-soft">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="text-muted small fw-medium">Correo electrónico</div>
            <div class="h5 fw-bold mt-1">
                @auth
                    {{ auth()->user()->email }}
                @endauth
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon bg-purple-soft">
                <i class="fas fa-shield-halved"></i>
            </div>
            <div class="text-muted small fw-medium">Nivel de acceso</div>
            <div class="h4 fw-bold mt-1">
                @auth
                    {{ ucfirst(auth()->user()->rol) }}
                @endauth
            </div>
        </div>
    </div>
</div>

<div class="table-card">
    <h4 class="fw-bold mb-3">Acciones disponibles</h4>

    @auth
        @if(auth()->user()->rol === 'admin')
            <p class="mb-2">Como <strong>administrador</strong> puedes acceder a:</p>
            <ul class="mb-0">
                <li>Home</li>
                <li>Clientes / Emprendedores</li>
                <li>Tiendas</li>
                <li>Usuarios</li>
            </ul>
        @elseif(auth()->user()->rol === 'emprendedor')
            <p class="mb-2">Como <strong>emprendedor</strong> puedes acceder a:</p>
            <ul class="mb-0">
                <li>Home</li>
                <li>Productos</li>
                <li>Pedidos</li>
                <li>Pagos</li>
            </ul>
        @elseif(auth()->user()->rol === 'cliente')
            <p class="mb-2">Como <strong>cliente</strong> puedes acceder a:</p>
            <ul class="mb-0">
                <li>Home</li>
                <li>Compras</li>
                <li>Pagos</li>
            </ul>
        @else
            <p class="mb-0 text-danger">Este usuario no tiene un rol válido asignado.</p>
        @endif
    @endauth
</div>

@endsection