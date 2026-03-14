@extends('dash.main')

@section('contenido')
<div class="mb-4">
    <h2 class="fw-bold m-0">Crear tienda</h2>
    <p class="text-muted m-0">Formulario de alta de tiendas</p>
</div>

@include('tiendas._errors')

<div class="table-card">
    <form action="{{ route('tiendas.store') }}" method="POST">
        @csrf
        @include('tiendas._form')

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-accent">Guardar</button>
            <a href="{{ route('tiendas.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection