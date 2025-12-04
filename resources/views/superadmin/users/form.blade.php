<!-- BLOQUE DE ERRORES PERSONALIZADO -->
@if ($errors->any())
    <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4" role="alert" style="background-color: #FFF5F5;">
        <div class="d-flex align-items-center gap-2 mb-2">
            <i class="bi bi-exclamation-triangle-fill text-danger"></i>
            <h6 class="mb-0 fw-bold text-danger">Por favor corrige los siguientes errores:</h6>
        </div>
        <ul class="mb-0 small text-muted ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- FILA 1: NOMBRES Y APELLIDOS -->
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="first_name" class="form-label small fw-bold text-uppercase" style="letter-spacing: 0.5px;">
            <i class="bi bi-person-lines-fill me-1" style="color: var(--color-acento);"></i> Nombre
        </label>
        <input type="text" 
               class="form-control" 
               id="first_name" 
               name="first_name" 
               placeholder="Ej. Juan"
               value="{{ old('first_name', $user['first_name'] ?? '') }}" 
               required>
    </div>
    <div class="col-md-6 mb-3">
        <label for="last_name" class="form-label small fw-bold text-uppercase" style="letter-spacing: 0.5px;">
            <i class="bi bi-person-lines-fill me-1" style="color: var(--color-acento);"></i> Apellido
        </label>
        <input type="text" 
               class="form-control" 
               id="last_name" 
               name="last_name" 
               placeholder="Ej. Pérez"
               value="{{ old('last_name', $user['last_name'] ?? '') }}" 
               required>
    </div>
</div>

<!-- FILA 2: CORREO ELECTRÓNICO -->
<div class="mb-3">
    <label for="email" class="form-label small fw-bold text-uppercase" style="letter-spacing: 0.5px;">
        <i class="bi bi-envelope-at-fill me-1" style="color: var(--color-acento);"></i> Correo Electrónico
    </label>
    <input type="email" 
           class="form-control" 
           id="email" 
           name="email" 
           placeholder="nombre@ejemplo.com"
           value="{{ old('email', $user['email'] ?? '') }}" 
           required>
</div>

<!-- FILA 3: ROL -->
<div class="mb-3">
    <label for="role" class="form-label small fw-bold text-uppercase" style="letter-spacing: 0.5px;">
        <i class="bi bi-shield-lock-fill me-1" style="color: var(--color-acento);"></i> Rol de Usuario
    </label>
    <div class="position-relative">
        <select name="role" id="role" class="form-select cursor-pointer" required>
            <option value="" disabled {{ old('role', $user['role'] ?? '') == '' ? 'selected' : '' }}>Selecciona un rol...</option>
            <option value="User" {{ old('role', $user['role'] ?? '') == 'User' ? 'selected' : '' }}>Usuario</option>
            <option value="Admin" {{ old('role', $user['role'] ?? '') == 'Admin' ? 'selected' : '' }}>Administrador</option>
            <option value="Super Admin" {{ old('role', $user['role'] ?? '') == 'Super Admin' ? 'selected' : '' }}>Super Administrador</option>
        </select>
        <!-- Icono decorativo flotante (opcional, si el CSS lo permite) -->
        <i class="bi bi-chevron-down position-absolute top-50 end-0 translate-middle-y me-3 pe-none text-muted small"></i>
    </div>
</div>

<!-- FILA 4: CONTRASEÑA (Solo si es creación) -->
@if (!$user)
<div class="p-3 rounded-4 mt-4" style="background-color: var(--color-fondo-crema); border: 1px dashed var(--color-verde-principal);">
    <div class="row">
        <div class="col-12 mb-2">
            <span class="badge bg-white text-dark border shadow-sm mb-2">
                <i class="bi bi-key-fill text-warning"></i> Seguridad
            </span>
        </div>
        <div class="col-md-6 mb-3 mb-md-0">
            <label for="password" class="form-label small fw-bold text-uppercase" style="color: var(--color-verde-oscuro);">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="********" required>
        </div>
        <div class="col-md-6">
            <label for="password_confirmation" class="form-label small fw-bold text-uppercase" style="color: var(--color-verde-oscuro);">Confirmar Contraseña</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="********" required>
        </div>
    </div>
    <div class="mt-2 d-flex align-items-center gap-2 text-muted">
        <i class="bi bi-info-circle small"></i>
        <small class="form-text mb-0" style="font-size: 0.8rem;">La contraseña debe tener al menos 8 caracteres.</small>
    </div>
</div>
@endif