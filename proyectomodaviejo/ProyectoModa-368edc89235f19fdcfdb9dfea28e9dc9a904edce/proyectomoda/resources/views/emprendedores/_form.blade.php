<div class="mb-3">
    <label class="form-label">Nombre</label>
    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $emprendedor->nombre ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Apellido</label>
    <input type="text" name="apellido" class="form-control" value="{{ old('apellido', $emprendedor->apellido ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Correo</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $emprendedor->email ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Teléfono</label>
    <input type="text" name="tel" class="form-control" value="{{ old('tel', $emprendedor->tel ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Nombre de la marca</label>
    <input type="text" name="nombre_marca" class="form-control" value="{{ old('nombre_marca', $detalle->nombre_marca ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Contraseña {{ isset($emprendedor) ? '(dejar vacío para no cambiar)' : '' }}</label>
    <input type="password" name="password" class="form-control">
</div>

<div class="mb-3">
    <label class="form-label">Confirmar contraseña</label>
    <input type="password" name="password_confirmation" class="form-control">
</div>