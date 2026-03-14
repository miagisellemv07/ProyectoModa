<div class="mb-3">
    <label class="form-label">Nombre</label>
    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $producto->nombre ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Descripción</label>
    <textarea name="descripcion" class="form-control" rows="4">{{ old('descripcion', $producto->descripcion ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Precio</label>
    <input type="number" step="0.01" name="precio" class="form-control" value="{{ old('precio', $producto->precio ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Stock</label>
    <input type="number" name="stock" class="form-control" value="{{ old('stock', $producto->stock ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Tienda</label>
    <select name="tienda_id" class="form-select">
        <option value="">Seleccione una tienda</option>
        @foreach($tiendas as $tienda)
            <option value="{{ $tienda->id }}" {{ old('tienda_id', $producto->tienda_id ?? '') == $tienda->id ? 'selected' : '' }}>
                {{ $tienda->nombre }}
            </option>
        @endforeach
    </select>
</div>