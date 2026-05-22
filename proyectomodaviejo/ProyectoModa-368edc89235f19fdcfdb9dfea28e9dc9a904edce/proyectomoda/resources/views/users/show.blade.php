@extends('dash.main')

@section('contenido')
<div class="mb-4">
    <h2 class="fw-bold m-0">Detalle del usuario</h2>
    <p class="text-muted m-0">Información completa del registro</p>
</div>

<div class="table-card">
    <p><strong>ID:</strong> {{ $usuario->id }}</p>
    <p><strong>Nombre:</strong> {{ $usuario->nombre }}</p>
    <p><strong>Apellido:</strong> {{ $usuario->apellido }}</p>
    <p><strong>Email:</strong> {{ $usuario->email }}</p>
    <p><strong>Teléfono:</strong> {{ $usuario->tel }}</p>
    <p><strong>Rol:</strong> {{ ucfirst($usuario->rol) }}</p>

    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection