@extends('dash.main')

@section('contenido')
<div class="mb-4">
    <h2 class="fw-bold m-0">Detalle del emprendedor</h2>
    <p class="text-muted m-0">Información completa del registro</p>
</div>

<div class="table-card">
    <p><strong>ID:</strong> {{ $emprendedor->id }}</p>
    <p><strong>Nombre:</strong> {{ $emprendedor->nombre }}</p>
    <p><strong>Apellido:</strong> {{ $emprendedor->apellido }}</p>
    <p><strong>Email:</strong> {{ $emprendedor->email }}</p>
    <p><strong>Teléfono:</strong> {{ $emprendedor->tel }}</p>
    <p><strong>Rol:</strong> Emprendedor</p>

    <a href="{{ route('dashboard.emprendedores') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection