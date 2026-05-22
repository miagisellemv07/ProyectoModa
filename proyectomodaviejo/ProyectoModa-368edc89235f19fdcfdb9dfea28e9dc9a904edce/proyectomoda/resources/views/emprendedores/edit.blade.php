@extends('dash.main')

@section('contenido')
<div class="mb-4">
    <h2 class="fw-bold m-0">Editar emprendedor</h2>
    <p class="text-muted m-0">Actualiza la información del emprendedor</p>
</div>

@include('emprendedores._errors')

<div class="table-card">
    <form action="{{ route('emprendedores.update', $emprendedor->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('emprendedores._form')

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-accent">Actualizar</button>
            <a href="{{ route('emprendedores.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection