@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="first_name" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $user['first_name'] ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="last_name" class="form-label">Apellido</label>
        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $user['last_name'] ?? '') }}" required>
    </div>
</div>

<div class="mb-3">
    <label for="email" class="form-label">Correo Electrónico</label>
    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user['email'] ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="role" class="form-label">Rol</label>
    <select name="role" id="role" class="form-select" required>
        <option value="User" {{ old('role', $user['role'] ?? '') == 'User' ? 'selected' : '' }}>Usuario</option>
        <option value="Admin" {{ old('role', $user['role'] ?? '') == 'Admin' ? 'selected' : '' }}>Administrador</option>
        <option value="Super Admin" {{ old('role', $user['role'] ?? '') == 'Super Admin' ? 'selected' : '' }}>Super Administrador</option>
    </select>
</div>

@if (!$user)
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
    </div>
</div>
<small class="form-text text-muted">La contraseña debe tener al menos 8 caracteres.</small>
@endif