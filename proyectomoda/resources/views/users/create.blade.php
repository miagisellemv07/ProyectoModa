@extends('dash.main')

@section('contenido')
<div class="mb-4">
    <h2 class="fw-bold m-0">Crear usuario</h2>
    <p class="text-muted m-0">Formulario de registro manual</p>
</div>

@include('users._errors')

<div class="table-card">
    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf

        @include('users._form')

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-accent">Guardar</button>
            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection