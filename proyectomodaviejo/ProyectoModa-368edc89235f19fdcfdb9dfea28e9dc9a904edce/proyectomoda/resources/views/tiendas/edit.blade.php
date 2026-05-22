@extends('dash.main')

@section('contenido')
<div class="mb-4">
    <h2 class="fw-bold m-0">Editar tienda</h2>
    <p class="text-muted m-0">Actualiza la información de la tienda</p>
</div>

@include('tiendas._errors')

<div class="table-card">
    <form action="{{ route('tiendas.update', $tienda->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('tiendas._form')

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-accent">Actualizar</button>
            <a href="{{ route('tiendas.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection