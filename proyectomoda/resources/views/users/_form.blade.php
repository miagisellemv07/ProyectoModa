<div class="mb-3">
    <label class="form-label">Nombre</label>
    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $usuario->nombre ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Apellido</label>
    <input type="text" name="apellido" class="form-control" value="{{ old('apellido', $usuario->apellido ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Correo</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $usuario->email ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Teléfono</label>
    <input type="text" name="tel" class="form-control" value="{{ old('tel', $usuario->tel ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Rol</label>
    <select name="rol" class="form-select">
        <option value="">Seleccione un rol</option>
        <option value="admin" {{ old('rol', $usuario->rol ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="emprendedor" {{ old('rol', $usuario->rol ?? '') == 'emprendedor' ? 'selected' : '' }}>Emprendedor</option>
        <option value="cliente" {{ old('rol', $usuario->rol ?? '') == 'cliente' ? 'selected' : '' }}>Cliente</option>
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Contraseña {{ isset($usuario) ? '(dejar vacío para no cambiar)' : '' }}</label>
    <input type="password" name="password" class="form-control">
</div>

<div class="mb-3">
    <label class="form-label">Confirmar contraseña</label>
    <input type="password" name="password_confirmation" class="form-control">
</div>