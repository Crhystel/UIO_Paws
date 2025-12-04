@extends('layouts.app')
@section('title', 'Postulación a Voluntariado')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    /* === VARIABLES === */
    :root {
        --color-verde-principal: #74C69D; 
        --color-verde-oscuro: #1B4332;    
        --color-verde-suave: #D8F3DC;     
        --color-acento: #40916C;          
        --color-fondo-crema: #F9FFF9;
    }

    body {
        font-family: 'Poppins', sans-serif;
        color: var(--color-verde-oscuro);
        background-color: var(--color-fondo-crema);
        background-image: radial-gradient(rgba(116, 198, 157, 0.4) 1.5px, transparent 1.5px);
        background-size: 30px 30px;
        background-attachment: fixed;
    }

    /* === TIPOGRAFÍA === */
    .hero-title { font-weight: 800; color: var(--color-verde-oscuro); }
    
    .highlight-shape { position: relative; z-index: 1; display: inline-block; }
    .highlight-shape::after {
        content: ''; position: absolute; bottom: 8px; left: -5px; width: 105%; height: 15px;
        background-color: var(--color-verde-principal); opacity: 0.5; 
        border-radius: 20px; z-index: -1; transform: rotate(-1deg);
    }

    /* === TARJETA === */
    .feature-card {
        background: white; border-radius: 30px; padding: 40px;
        border: 1px solid rgba(116, 198, 157, 0.1); 
        box-shadow: 0 10px 30px rgba(27, 67, 50, 0.03);
    }

    /* === INPUTS === */
    .form-control-rounded, .form-select-rounded {
        border-radius: 20px; border: 1px solid #ddd; padding: 12px 20px;
    }
    .form-control-rounded:focus, .form-select-rounded:focus {
        border-color: var(--color-verde-principal); box-shadow: 0 0 0 3px rgba(116, 198, 157, 0.2);
    }
    .form-label {
        color: var(--color-verde-oscuro); margin-bottom: 8px;
    }

    /* === BOTÓN === */
    .btn-cta {
        background: linear-gradient(135deg, var(--color-verde-principal), var(--color-acento));
        color: white; padding: 14px 30px; border-radius: 50px;
        font-weight: 700; border: none; width: 100%; font-size: 1.1rem;
        box-shadow: 0 10px 25px rgba(116, 198, 157, 0.4);
        transition: all 0.3s ease;
    }
    .btn-cta:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(116, 198, 157, 0.6);
        color: white;
    }

    /* === ALERTA PERSONALIZADA === */
    .alert-custom {
        background-color: var(--color-verde-suave);
        color: var(--color-verde-oscuro);
        border-radius: 20px;
        border: 1px solid var(--color-verde-principal);
    }

    /* === BLOBS === */
    .blob { position: absolute; border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%; filter: blur(60px); z-index: -1; opacity: 0.6; }
    .blob-1 { top: -5%; left: -10%; width: 500px; height: 500px; background-color: var(--color-verde-suave); }
    .blob-2 { bottom: -5%; right: -10%; width: 400px; height: 400px; background-color: #95D5B2; }

</style>

<!-- Blobs de fondo -->
<div class="blob blob-1"></div>
<div class="blob blob-2"></div>

<div class="container py-5 position-relative" style="z-index: 5;">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <!-- TARJETA PRINCIPAL -->
            <div class="feature-card">
                
                <!-- Encabezado de la tarjeta -->
                <div class="text-center mb-5">
                    <h2 class="hero-title mb-2">
                        Únete a nuestro <span class="highlight-shape">Equipo</span>
                    </h2>
                    <p class="text-muted">Tu tiempo puede cambiar la vida de muchos peludos.</p>
                </div>

                <!-- Alerta de Oportunidad -->
                @if(isset($opportunity) && $opportunity)
                    <div class="alert alert-custom d-flex align-items-center mb-4 p-3 shadow-sm">
                        <i class="bi bi-info-circle-fill fs-4 me-3" style="color: var(--color-acento);"></i>
                        <div>
                            <span class="d-block small text-uppercase fw-bold opacity-75">Estás aplicando para:</span>
                            <strong class="fs-5">{{ $opportunity['title'] }}</strong>
                        </div>
                    </div>
                @endif

                <!-- Formulario -->
                <form action="{{ route('user.volunteer.store') }}" method="POST">
                    @csrf
                    
                    @if(isset($opportunity) && $opportunity)
                        <input type="hidden" name="id_volunteer_opportunity" value="{{ $opportunity['id_volunteer_opportunity'] }}">
                    @endif

                    <!-- Disponibilidad -->
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase">
                            <i class="bi bi-calendar-check me-1 text-success"></i> Disponibilidad Horaria
                        </label>
                        <select name="availability" class="form-select form-select-rounded" required>
                            <option value="">Selecciona...</option>
                            <option value="Fines de semana">Solo fines de semana</option>
                            <option value="Entre semana mañanas">Entre semana (Mañanas)</option>
                            <option value="Entre semana tardes">Entre semana (Tardes)</option>
                            <option value="Flexible">Horario Flexible</option>
                        </select>
                    </div>

                    <!-- Experiencia -->
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase">
                            <i class="bi bi-person-hearts me-1 text-danger"></i> Experiencia Previa con Animales
                        </label>
                        <textarea name="experience" class="form-control form-control-rounded" rows="3" 
                                  placeholder="¿Has tenido mascotas o trabajado en refugios antes?" required></textarea>
                    </div>

                    <!-- Motivación -->
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase">
                            <i class="bi bi-lightbulb me-1 text-warning"></i> Motivación Principal
                        </label>
                        <div class="form-text mb-2 ms-1">Cuéntanos por qué quieres ser parte de este cambio.</div>
                        <textarea name="motivation" class="form-control form-control-rounded" rows="5" 
                                  required minlength="50">{{ old('motivation') }}</textarea>
                        @error('motivation') <span class="text-danger small ms-2">{{ $message }}</span> @enderror
                    </div>

                    <!-- Términos -->
                    <div class="form-check mb-5 p-3 rounded-4" style="background-color: var(--color-fondo-crema); border: 1px dashed var(--color-verde-principal);">
                        <input class="form-check-input ms-1" type="checkbox" name="terms_accepted" id="terms" required style="cursor: pointer;">
                        <label class="form-check-label small ms-2" for="terms" style="cursor: pointer;">
                            Acepto comprometerme con las normas del refugio y tratar a los animales con respeto y amor.
                        </label>
                    </div>

                    <!-- Botón Enviar -->
                    <div class="d-grid">
                        <button type="submit" class="btn-cta">
                            <i class="bi bi-send-fill me-2"></i> Enviar Solicitud
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection