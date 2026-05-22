<div class="mb-3">
    <label class="form-label">Nombre</label>
    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $tienda->nombre ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Logo</label>
    <input type="text" name="logo" class="form-control" value="{{ old('logo', $tienda->logo ?? '') }}" placeholder="Ejemplo: logo.png o URL del logo">
</div>

<div class="mb-3">
    <label class="form-label">Descripción</label>
    <textarea name="descripcion" class="form-control" rows="4">{{ old('descripcion', $tienda->descripcion ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Categoría</label>
    <input type="text" name="categoria" class="form-control" value="{{ old('categoria', $tienda->categoria ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Emprendedor asignado</label>
    <select name="emprendedor_id" class="form-select">
        <option value="">Seleccione un emprendedor</option>
        @foreach($emprendedores as $emp)
            <option value="{{ $emp->id }}" {{ old('emprendedor_id', $tienda->emprendedor_id ?? '') == $emp->id ? 'selected' : '' }}>
                {{ $emp->usuario->nombre ?? '' }} {{ $emp->usuario->apellido ?? '' }} - {{ $emp->nombre_marca }}
            </option>
        @endforeach
    </select>
</div>