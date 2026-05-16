@extends('dash.main')

@section('contenido')

<div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-3">
    <div>
        <h2 class="fw-bold m-0 text-dark">Productos</h2>
        <p class="text-muted m-0">Vista exclusiva para emprendedores.</p>
    </div>
</div>

<div class="user-card mb-4">
    <h4 class="fw-bold mb-3">Módulo de Productos</h4>
    <p class="mb-0">
        Aquí el emprendedor podrá gestionar sus productos.
    </p>
</div>

<div class="user-card">
    <h4 class="fw-bold mb-4">Agregar producto</h4>

    <form
        action="{{ url('/api/productos') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf

        <div class="mb-3">
            <label class="form-label fw-bold">Nombre del producto</label>
            <input
                type="text"
                name="nombre"
                class="form-control"
                placeholder="Ejemplo: Vestido elegante"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Descripción</label>
            <textarea
                name="descripcion"
                class="form-control"
                rows="3"
                placeholder="Describe el producto"
                required
            ></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Precio</label>
            <input
                type="number"
                step="0.01"
                name="precio"
                class="form-control"
                placeholder="399.99"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Stock</label>
            <input
                type="number"
                name="stock"
                class="form-control"
                placeholder="20"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">ID de tienda</label>
            <input
                type="number"
                name="tienda_id"
                class="form-control"
                placeholder="Ejemplo: 1"
                required
            >
        </div>

        <div class="mb-4">
            <label class="form-label fw-bold">Imagen del producto</label>
            <input
                type="file"
                name="imagen"
                class="form-control"
                accept="image/png, image/jpeg, image/jpg, image/webp"
            >
        </div>

        <button type="submit" class="btn btn-primary">
            Guardar producto
        </button>
    </form>
</div>

@endsection