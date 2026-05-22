@extends('dash.main')

@section('contenido')
<div class="mb-4">
    <h2 class="fw-bold m-0">Crear emprendedor</h2>
    <p class="text-muted m-0">Formulario de registro de emprendedores</p>
</div>

@include('emprendedores._errors')

<div class="table-card">
    <form action="{{ route('emprendedores.store') }}" method="POST">
        @csrf
        @include('emprendedores._form')

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-accent">Guardar</button>
            <a href="{{ route('emprendedores.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection