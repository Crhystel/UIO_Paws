@extends('layouts.app')

@section('title', 'Crear Cuenta')

@section('content')

<!-- ========================================== -->
<!-- ESTILOS ESPECÍFICOS PARA REGISTRO          -->
<!-- ========================================== -->
<style>
    :root {
        --color-verde-principal: #74C69D; 
        --color-verde-oscuro: #1B4332;    
        --color-acento: #40916C;
        --color-fondo-crema: #F9FFF9;
    }

    /* Tarjeta contenedora */
    .feature-card {
        background: white;
        border-radius: 30px;
        padding: 40px 30px;
        border: 1px solid rgba(116, 198, 157, 0.2); 
        box-shadow: 0 15px 40px rgba(27, 67, 50, 0.05);
        position: relative;
    }

    /* Inputs redondeados y suaves */
    .form-control, .form-select {
        border-radius: 50px;
        padding: 12px 20px;
        border: 1px solid #e0e0e0;
        background-color: #fcfcfc;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        background-color: white;
        border-color: var(--color-verde-principal);
        box-shadow: 0 0 0 4px rgba(116, 198, 157, 0.15);
    }

    /* Labels estilizados */
    .form-label {
        font-weight: 700;
        font-size: 0.8rem;
        color: var(--color-acento);
        margin-left: 10px;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Botón de Acción */
    .btn-cta {
        background: linear-gradient(135deg, var(--color-verde-principal), var(--color-acento));
        color: white; padding: 14px; border-radius: 50px;
        font-weight: 700; border: none;
        box-shadow: 0 5px 15px rgba(116, 198, 157, 0.4);
        transition: all 0.3s ease; width: 100%; display: block;
    }
    .btn-cta:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(116, 198, 157, 0.6);
        color: white;
    }

    /* Títulos de sección */
    .section-title {
        color: var(--color-verde-oscuro);
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        display: flex; align-items: center; gap: 10px;
    }
    .section-title::after {
        content: ''; flex-grow: 1; height: 1px; background-color: #e0e0e0;
    }

    /* Icono de encabezado */
    .register-icon {
        width: 60px; height: 60px;
        background-color: var(--color-verde-suave, #D8F3DC);
        color: var(--color-verde-oscuro);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 15px auto;
        font-size: 1.8rem;
    }

    .link-custom { color: var(--color-acento); font-weight: 600; text-decoration: none; }
    .link-custom:hover { color: var(--color-verde-oscuro); text-decoration: underline; }
</style>

<div class="row justify-content-center my-4">
    <div class="col-md-10 col-lg-8">
        
        <div class="feature-card">
            
            <!-- Encabezado -->
            <div class="text-center mb-5">
                <div class="register-icon">
                    <i class="bi bi-person-plus-fill"></i>
                </div>
                <h2 class="fw-bold" style="color: var(--color-verde-oscuro);">Únete a la familia</h2>
                <p class="text-muted">Completa tus datos para ser parte de UIO Paws.</p>
            </div>

            <form method="POST" action="{{ route('register.submit') }}">
                @csrf
                
                <!-- SECCIÓN 1: DATOS PERSONALES -->
                <div class="section-title">
                    <i class="bi bi-person-vcard text-success"></i> Información Personal
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="first_name" class="form-label">Primer Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                               id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="Ej. Ana" required>
                        @error('first_name') <div class="invalid-feedback ms-3">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-4">
                        <label for="middle_name" class="form-label">Segundo Nombre</label>
                        <input type="text" class="form-control @error('middle_name') is-invalid @enderror" 
                               id="middle_name" name="middle_name" value="{{ old('middle_name') }}" placeholder="Ej. María">
                        @error('middle_name') <div class="invalid-feedback ms-3">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                     <div class="col-md-6 mb-4">
                        <label for="last_name" class="form-label">Apellido Paterno <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                               id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Ej. López" required>
                        @error('last_name') <div class="invalid-feedback ms-3">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-4">
                        <label for="second_last_name" class="form-label">Apellido Materno</label>
                        <input type="text" class="form-control @error('second_last_name') is-invalid @enderror" 
                               id="second_last_name" name="second_last_name" value="{{ old('second_last_name') }}" placeholder="Ej. Silva">
                        @error('second_last_name') <div class="invalid-feedback ms-3">{{ $message }}</div> @enderror
                    </div>
                </div>
                
                <!-- SECCIÓN 2: IDENTIFICACIÓN Y CONTACTO -->
                <div class="section-title mt-2">
                    <i class="bi bi-person-badge text-success"></i> Identificación y Contacto
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="document_type" class="form-label">Tipo de Documento <span class="text-danger">*</span></label>
                        <select class="form-select @error('document_type') is-invalid @enderror" id="document_type" name="document_type" required>
                            <option value="" disabled selected>Selecciona...</option>
                            <option value="Cédula" {{ old('document_type') == 'Cedula' ? 'selected' : '' }}>Cédula</option>
                            <option value="Pasaporte" {{ old('document_type') == 'Pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                            <option value="Otro" {{ old('document_type') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('document_type') <div class="invalid-feedback ms-3">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-4">
                        <label for="document_number" class="form-label">Número de Documento <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('document_number') is-invalid @enderror" 
                               id="document_number" name="document_number" value="{{ old('document_number') }}" placeholder="Ej. 1712345678" required>
                        @error('document_number') <div class="invalid-feedback ms-3">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="phone" class="form-label">Teléfono de Contacto <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 rounded-start-pill ps-3 text-muted">
                            <i class="bi bi-telephone-fill"></i>
                        </span>
                        <input type="tel" class="form-control border-start-0 rounded-end-pill @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone') }}" placeholder="0991234567" required>
                        @error('phone') <div class="invalid-feedback ms-3">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- SECCIÓN 3: SEGURIDAD DE LA CUENTA -->
                <div class="section-title mt-2">
                    <i class="bi bi-shield-lock text-success"></i> Seguridad de la Cuenta
                </div>

                <div class="mb-4">
                    <label for="email" class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email') }}" placeholder="nombre@ejemplo.com" required>
                    @error('email') <div class="invalid-feedback ms-3">{{ $message }}</div> @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="password" class="form-label">Contraseña <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" placeholder="********" required>
                        @error('password') <div class="invalid-feedback ms-3">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-4">
                        <label for="password_confirmation" class="form-label">Confirmar Contraseña <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation" placeholder="********" required>
                    </div>
                </div>

                <!-- Botón de Registro -->
                <div class="d-grid mt-4 pt-2">
                    <button type="submit" class="btn-cta">
                        Crear mi cuenta
                    </button>
                </div>

                <div class="text-center mt-4 pt-3 border-top border-light">
                    <p class="mb-0 text-muted">¿Ya tienes una cuenta?</p>
                    <a href="{{ route('login') }}" class="link-custom">Inicia sesión aquí</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection