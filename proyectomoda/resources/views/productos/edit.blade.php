@extends('dash.main')

@section('contenido')
<div class="mb-4">
    <h2 class="fw-bold m-0">Editar producto</h2>
    <p class="text-muted m-0">Actualiza la información del producto</p>
</div>

@include('productos._errors')

<div class="table-card">
    <form action="{{ route('productos.update', $producto->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('productos._form')

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-accent">Actualizar</button>
            <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection