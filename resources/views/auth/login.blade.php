@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')

<!-- ========================================== -->
<!-- ESTILOS ESPECÍFICOS PARA LOGIN             -->
<!-- ========================================== -->
<style>
    /* Reutilizamos las variables del sistema */
    :root {
        --color-verde-principal: #74C69D; 
        --color-verde-oscuro: #1B4332;    
        --color-acento: #40916C;          
    }

    /* Tarjeta flotante central */
    .feature-card {
        background: white;
        border-radius: 30px;
        padding: 40px 30px;
        border: 1px solid rgba(116, 198, 157, 0.2); 
        box-shadow: 0 15px 40px rgba(27, 67, 50, 0.05);
        position: relative;
        overflow: hidden;
    }

    /* Inputs redondeados */
    .form-control {
        border-radius: 50px;
        padding: 12px 20px;
        border: 1px solid #e0e0e0;
        background-color: #f9f9f9;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        background-color: white;
        border-color: var(--color-verde-principal);
        box-shadow: 0 0 0 4px rgba(116, 198, 157, 0.15);
    }

    /* Labels con estilo */
    .form-label {
        font-weight: 600;
        font-size: 0.85rem;
        color: var(--color-verde-oscuro);
        margin-left: 10px;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Botón Principal */
    .btn-cta {
        background: linear-gradient(135deg, var(--color-verde-principal), var(--color-acento));
        color: white;
        padding: 12px;
        border-radius: 50px;
        font-weight: 700;
        border: none;
        box-shadow: 0 5px 15px rgba(116, 198, 157, 0.4);
        transition: all 0.3s ease;
        width: 100%;
        display: block;
    }

    .btn-cta:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(116, 198, 157, 0.6);
        color: white;
    }

    /* Subrayado animado del título */
    .highlight-shape {
        position: relative; display: inline-block; z-index: 1;
    }
    .highlight-shape::after {
        content: ''; position: absolute; bottom: 5px; left: -5px; width: 105%; height: 12px;
        background-color: var(--color-verde-principal); opacity: 0.4; 
        border-radius: 20px; z-index: -1; transform: rotate(-2deg);
    }

    /* Icono superior */
    .login-icon {
        width: 70px; height: 70px;
        background-color: var(--color-verde-suave, #D8F3DC);
        color: var(--color-verde-oscuro);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px auto;
        font-size: 2rem;
    }
    
    .link-custom {
        color: var(--color-acento);
        font-weight: 600;
        text-decoration: none;
        position: relative;
    }
    .link-custom:hover { color: var(--color-verde-oscuro); }
</style>

<div class="row justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-6 col-lg-5 col-xl-4">
        
        <!-- Tarjeta de Login -->
        <div class="feature-card">
            
            <!-- Encabezado -->
            <div class="text-center mb-4">
                <div class="login-icon">
                    <i class="bi bi-person-fill"></i>
                </div>
                <h3 class="fw-bold" style="color: var(--color-verde-oscuro);">
                    ¡Hola de <span class="highlight-shape">nuevo!</span>
                </h3>
                <p class="text-muted small">Ingresa tus credenciales para continuar.</p>
            </div>

            <div class="px-2">
                <form method="POST" action="{{ route('login.submit') }}">
                    @csrf
                    
                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="form-label">
                            <i class="bi bi-envelope-fill me-1" style="color: var(--color-acento);"></i> Correo Electrónico
                        </label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               placeholder="ejemplo@correo.com"
                               value="{{ old('email') }}" 
                               required 
                               autofocus>
                        @error('email')
                            <div class="invalid-feedback ms-3">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Contraseña -->
                    <div class="mb-4">
                        <label for="password" class="form-label">
                            <i class="bi bi-key-fill me-1" style="color: var(--color-acento);"></i> Contraseña
                        </label>
                        <input type="password" 
                               class="form-control" 
                               id="password" 
                               name="password" 
                               placeholder="••••••••"
                               required>
                    </div>

                    <!-- Botón -->
                    <div class="d-grid mb-4">
                         <button type="submit" class="btn-cta">
                            Ingresar <i class="bi bi-arrow-right-short fs-5 align-middle"></i>
                         </button>
                    </div>
                </form>

                <!-- Footer del formulario -->
                <div class="text-center mt-3 pt-3 border-top border-light">
                    <small class="text-muted">¿Aún no eres parte de UIO Paws?</small> <br>
                    <a href="{{ route('register.form') }}" class="link-custom">
                        Regístrate aquí
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Decoración extra: Texto inferior -->
        <div class="text-center mt-4">
            <small class="text-muted opacity-75">
                Al ingresar, aceptas nuestros términos y condiciones de adopción.
            </small>
        </div>

    </div>
</div>
@endsection