@extends('dash.main')

@section('contenido')
<div class="mb-4">
    <h2 class="fw-bold m-0">Detalle del producto</h2>
    <p class="text-muted m-0">Información completa del producto</p>
</div>

<div class="table-card">
    <p><strong>ID:</strong> {{ $producto->id }}</p>
    <p><strong>Nombre:</strong> {{ $producto->nombre }}</p>
    <p><strong>Descripción:</strong> {{ $producto->descripcion }}</p>
    <p><strong>Precio:</strong> ${{ number_format($producto->precio, 2) }}</p>
    <p><strong>Stock:</strong> {{ $producto->stock }}</p>
    <p><strong>Tienda:</strong> {{ $producto->tienda->nombre ?? 'Sin tienda' }}</p>

    <a href="{{ route('productos.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection