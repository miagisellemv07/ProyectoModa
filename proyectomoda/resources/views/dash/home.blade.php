@extends('dash.main')

@section('contenido')

<div class="d-flex justify-content-between align-items-center mb-5">
    <div>
        <h2 class="fw-bold m-0">Resumen General</h2>
        <p class="text-muted m-0">Panel principal de Virtuality Emprendedores Mall</p>
    </div>

    <div class="text-muted small">
        Última actualización: Hoy, 20:45
    </div>
</div>

<!-- Tarjetas de estadísticas -->
<div class="row g-4 mb-5">

    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon bg-accent-soft">
                <i class="fas fa-store"></i>
            </div>

            <div class="text-muted small fw-medium">
                Tiendas Registradas
            </div>

            <div class="h3 fw-bold mt-1">
                24
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon bg-blue-soft">
                <i class="fas fa-box"></i>
            </div>

            <div class="text-muted small fw-medium">
                Productos Activos
            </div>

            <div class="h3 fw-bold mt-1">
                186
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon bg-green-soft">
                <i class="fas fa-shopping-cart"></i>
            </div>

            <div class="text-muted small fw-medium">
                Órdenes Completadas
            </div>

            <div class="h3 fw-bold mt-1">
                93
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon bg-purple-soft">
                <i class="fas fa-users"></i>
            </div>

            <div class="text-muted small fw-medium">
                Usuarios Registrados
            </div>

            <div class="h3 fw-bold mt-1">
                58
            </div>
        </div>
    </div>

</div>

@endsection