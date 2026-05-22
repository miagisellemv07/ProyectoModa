@extends('dash.main')

@section('contenido')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold m-0">Usuarios</h2>
        <p class="text-muted m-0">CRUD de usuarios del sistema</p>
    </div>

    <a href="{{ route('usuarios.create') }}" class="btn btn-accent">
        <i class="fas fa-plus"></i> Nuevo usuario
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
                    <th>Nombre completo</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Rol</th>
                    <th width="220">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->id }}</td>
                        <td>{{ $usuario->nombre }} {{ $usuario->apellido }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td>{{ $usuario->tel }}</td>
                        <td>
                            <span class="badge bg-secondary">{{ ucfirst($usuario->rol) }}</span>
                        </td>
                        <td class="d-flex gap-2">
                            <a href="{{ route('usuarios.show', $usuario->id) }}" class="btn btn-sm btn-info text-white">
                                Ver
                            </a>

                            <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-sm btn-warning text-dark">
                                Editar
                            </a>

                            <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" class="form-eliminar">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No hay usuarios registrados.</td>
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
                title: '¿Eliminar usuario?',
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection