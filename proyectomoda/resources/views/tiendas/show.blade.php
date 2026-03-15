@extends('dash.main')

@section('contenido')
<div class="mb-4">
    <h2 class="fw-bold m-0">Detalle de la tienda</h2>
    <p class="text-muted m-0">Información completa del registro</p>
</div>

<div class="table-card">
    <p><strong>ID:</strong> {{ $tienda->id }}</p>
    <p><strong>Nombre:</strong> {{ $tienda->nombre }}</p>
    <p><strong>Categoría:</strong> {{ $tienda->categoria }}</p>
    <p><strong>Logo:</strong> {{ $tienda->logo }}</p>
    <p><strong>Descripción:</strong> {{ $tienda->descripcion }}</p>
    <p><strong>Emprendedor:</strong>
        {{ $tienda->emprendedor->usuario->nombre ?? '' }}
        {{ $tienda->emprendedor->usuario->apellido ?? '' }}
    </p>
    <p><strong>Marca:</strong> {{ $tienda->emprendedor->nombre_marca ?? 'Sin marca' }}</p>

    <a href="{{ route('tiendas.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection