@extends('dash.main')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">Productos</h2>
        <p class="text-muted m-0">Vista exclusiva para emprendedores</p>
    </div>

    <a href="{{ route('productos.create') }}" class="btn btn-accent">
        <i class="fas fa-plus"></i> Nuevo producto
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
                    <th>Tienda</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th width="220">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productos as $producto)
                    <tr>
                        <td>{{ $producto->id }}</td>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->tienda->nombre ?? 'Sin tienda' }}</td>
                        <td>${{ number_format($producto->precio, 2) }}</td>
                        <td>{{ $producto->stock }}</td>
                        <td class="d-flex gap-2">
                            <a href="{{ route('productos.show', $producto->id) }}" class="btn btn-sm btn-info text-white">Ver</a>
                            <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-sm btn-warning text-dark">Editar</a>
                            <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="form-eliminar">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No hay productos registrados.</td>
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
            title: '¿Eliminar producto?',
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