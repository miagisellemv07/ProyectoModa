@extends('dash.main')

@section('contenido')
<div class="mb-4">
    <h2 class="fw-bold m-0">Crear producto</h2>
    <p class="text-muted m-0">Formulario de alta de productos</p>
</div>

@include('productos._errors')

<div class="table-card">
    <form action="{{ route('productos.store') }}" method="POST">
        @csrf
        @include('productos._form')

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-accent">Guardar</button>
            <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection