@extends('dash.main')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">Tiendas</h2>
        <p class="text-muted m-0">CRUD de tiendas según tu tabla actual</p>
    </div>

    <a href="{{ route('tiendas.create') }}" class="btn btn-accent">
        <i class="fas fa-plus"></i> Nueva tienda
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success rounded-4 shadow-sm">
        {{ session('success') }}
    </div>
@endif

<div class="table-card">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Logo</th>
                    <th>Emprendedor</th>
                    <th width="220">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tiendas as $tienda)
                    <tr>
                        <td>{{ $tienda->id }}</td>
                        <td>{{ $tienda->nombre }}</td>
                        <td>{{ $tienda->categoria }}</td>
                        <td>{{ $tienda->logo }}</td>
                        <td>
                            {{ $tienda->emprendedor->usuario->nombre ?? '' }}
                            {{ $tienda->emprendedor->usuario->apellido ?? '' }}
                        </td>
                        <td class="d-flex gap-2">
                            <a href="{{ route('tiendas.show', $tienda->id) }}" class="btn btn-sm btn-info text-white">Ver</a>
                            <a href="{{ route('tiendas.edit', $tienda->id) }}" class="btn btn-sm btn-warning text-dark">Editar</a>
                            <form action="{{ route('tiendas.destroy', $tienda->id) }}" method="POST" class="form-eliminar">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No hay tiendas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.form-eliminar').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: '¿Eliminar tienda?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
});
</script>
@endsection