{{-- resources/views/admin/applications/volunteer/review.blade.php --}}

@extends('layouts.app') 

@section('title', 'Revisar Solicitud de Voluntariado')

@section('content')

<!-- === ESTILOS DEL DISEÑO (UIO PAWS) === -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    :root {
        /* === PALETA DE COLORES === */
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
        overflow-x: hidden;
        background-image: radial-gradient(rgba(116, 198, 157, 0.4) 1.5px, transparent 1.5px);
        background-size: 30px 30px;
        background-attachment: fixed;
    }

    /* === TÍTULOS Y TEXTOS === */
    .hero-title { font-weight: 800; color: var(--color-verde-oscuro); }

    .highlight-shape { position: relative; z-index: 1; display: inline-block; }
    .highlight-shape::after {
        content: ''; position: absolute; bottom: 8px; left: -5px; width: 105%; height: 20px;
        background-color: var(--color-verde-principal); opacity: 0.5; 
        border-radius: 20px; z-index: -1; transform: rotate(-2deg);
    }

    /* === TARJETAS === */
    .feature-card {
        background: white; border-radius: 30px; padding: 35px 30px;
        height: 100%;
        border: 1px solid rgba(116, 198, 157, 0.1); 
        box-shadow: 0 10px 30px rgba(27, 67, 50, 0.03);
        transition: transform 0.3s ease;
        overflow-wrap: break-word;
    }
    .feature-card:hover { box-shadow: 0 15px 35px rgba(116, 198, 157, 0.15); }

    /* === BOTONES === */
    .btn-cta {
        background: linear-gradient(135deg, var(--color-verde-principal), var(--color-acento));
        color: white; padding: 12px 30px; border-radius: 50px; font-weight: 700;
        border: none; box-shadow: 0 10px 25px rgba(116, 198, 157, 0.4);
        transition: all 0.3s ease; text-decoration: none; display: block; width: 100%; text-align: center;
    }
    .btn-cta:hover { transform: translateY(-2px); box-shadow: 0 15px 35px rgba(116, 198, 157, 0.6); color: white; }

    /* === ICONOS CIRCULARES PERFECTOS (SOLUCIÓN) === */
    .icon-circle {
        width: 70px;          /* Ancho fijo */
        height: 70px;         /* Alto fijo igual al ancho */
        border-radius: 50%;   /* Círculo perfecto */
        display: inline-flex; /* Para comportarse bien con texto */
        align-items: center;  /* Centrado vertical */
        justify-content: center; /* Centrado horizontal */
        background-color: var(--color-verde-suave);
        color: var(--color-verde-oscuro);
        flex-shrink: 0;       /* Evita que se aplaste */
    }

    /* === DATOS === */
    .data-label {
        color: var(--color-acento); font-weight: 700; text-transform: uppercase;
        font-size: 0.8rem; letter-spacing: 0.5px; margin-bottom: 2px;
    }
    .data-value {
        font-weight: 500; color: var(--color-verde-oscuro); font-size: 1rem;
        margin-bottom: 1rem; padding-bottom: 0.5rem;
        border-bottom: 1px dashed var(--color-verde-suave);
        overflow-wrap: break-word;
        word-wrap: break-word;
        word-break: break-word;
        hyphens: auto;
    }
    .data-value:last-child { border-bottom: none; margin-bottom: 0; }

    /* === FORMULARIOS === */
    .form-select-custom, .form-control-custom {
        border-radius: 20px; border: 2px solid var(--color-verde-suave); padding: 12px 20px;
    }
    .form-select-custom:focus, .form-control-custom:focus {
        border-color: var(--color-verde-principal); box-shadow: 0 0 0 4px rgba(116, 198, 157, 0.2);
    }

    /* === BLOBS === */
    .blob { position: absolute; border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%; filter: blur(60px); z-index: -1; animation: float 8s ease-in-out infinite; }
    .blob-1 { top: -10%; left: 30%; width: 500px; height: 500px; background-color: var(--color-verde-suave); opacity: 0.6; }
    .blob-2 { bottom: 0; right: -10%; width: 350px; height: 350px; background-color: #95D5B2; opacity: 0.5; animation-delay: 2s; }
    
    @keyframes float { 0% { transform: translate(0, 0); } 50% { transform: translate(20px, 30px); } 100% { transform: translate(0, 0); } }
</style>

<div class="blob blob-1"></div>
<div class="blob blob-2"></div>

<div class="container pt-5 pb-5 position-relative" style="z-index: 5;">
    
    <!-- Encabezado -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5">
        <div>
            <h1 class="hero-title display-5 mb-2">Solicitud de <span class="highlight-shape">Voluntariado</span></h1>
            <p class="text-muted mb-0 lead" style="font-size: 1.1rem;">
                Ticket <strong>#{{ $application['id_volunteer_applications'] }}</strong> &bull; 
                <small class="fs-6"><i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($application['application_date'])->format('d/m/Y H:i') }}</small>
            </p>
        </div>
        <a href="{{ route('admin.applications.index') }}" class="text-decoration-none fw-bold mt-3 mt-md-0" style="color: var(--color-acento);">
            <i class="bi bi-arrow-left-circle me-1"></i> Volver al listado
        </a>
    </div>

    <div class="row g-4">
        {{-- Columna Izquierda: Información --}}
        <div class="col-lg-8">
            <div class="d-flex flex-column gap-4">
                
                {{-- 1. Oportunidad / Puesto --}}
                <div class="feature-card position-relative overflow-hidden" style="border-left: 5px solid var(--color-verde-principal);">
                    <div class="d-flex align-items-center">
                        <!-- Círculo corregido con clase .icon-circle -->
                        <div class="icon-circle me-3">
                            <i class="bi bi-briefcase-fill fs-3"></i>
                        </div>
                        <div>
                            <div class="data-label mb-1">Puesto Solicitado</div>
                            @if(isset($application['opportunity']))
                                <h3 class="fw-bold mb-2" style="color: var(--color-verde-oscuro);">{{ $application['opportunity']['title'] }}</h3>
                                <p class="mb-0 text-muted small">
                                    {{ Str::limit($application['opportunity']['description'], 200) }}
                                </p>
                            @else
                                <h3 class="fw-bold mb-2 text-secondary">Voluntariado General</h3>
                                <p class="mb-0 text-muted small">El usuario ofrece su ayuda sin especificar un puesto activo.</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- 2. Datos del Candidato --}}
                <div class="feature-card">
                    <h5 class="fw-bold mb-4 border-bottom pb-3" style="border-color: var(--color-verde-suave) !important;">
                        <i class="bi bi-person-lines-fill me-2"></i>Datos del Candidato
                    </h5>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="data-label">Nombre Completo</div>
                            <div class="data-value">{{ $application['user']['first_name'] }} {{ $application['user']['last_name'] }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="data-label">Correo Electrónico</div>
                            <div class="data-value">
                                <a href="mailto:{{ $application['user']['email'] }}" class="text-decoration-none fw-bold" style="color: var(--color-acento);">
                                    {{ $application['user']['email'] }}
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="data-label">Teléfono</div>
                            <div class="data-value">{{ $application['user']['phone'] ?? 'No registrado' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="data-label">Miembro Desde</div>
                            <div class="data-value">{{ \Carbon\Carbon::parse($application['user']['created_at'] ?? now())->format('Y') }}</div>
                        </div>
                    </div>
                </div>

                {{-- 3. Carta de Motivación --}}
                <div class="feature-card">
                    <h5 class="fw-bold mb-4 border-bottom pb-3" style="border-color: var(--color-verde-suave) !important;">
                        <i class="bi bi-file-text-fill me-2"></i>Carta de Presentación
                    </h5>
                    
                    <div class="p-4 rounded-4" style="background-color: #F8FDF9; border: 1px dashed var(--color-verde-principal);">
                        {{-- Protección para saltos de línea y textos largos --}}
                        <div style="white-space: pre-line; line-height: 1.8; color: var(--color-verde-oscuro); overflow-wrap: break-word;">
                            {!! nl2br(e($application['motivation'])) !!}
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Columna Derecha: Gestión --}}
        <div class="col-lg-4">
            <div class="feature-card sticky-top" style="top: 20px; z-index: 10;">
                <div class="text-center mb-4">
                    <!-- Círculo corregido con clase .icon-circle y mx-auto para centrar -->
                    <div class="icon-circle mx-auto mb-3">
                        <i class="bi bi-gear-fill fs-2"></i>
                    </div>
                    <h5 class="fw-bold">Gestión Administrativa</h5>
                    <p class="text-muted small">Evalúa el perfil y actualiza el estado.</p>
                </div>

                <div class="mb-4 text-center">
                    <span class="text-uppercase fw-bold text-muted" style="font-size: 0.75rem; letter-spacing: 1px;">Estado Actual</span>
                    <div class="mt-2">
                        <span class="badge rounded-pill px-4 py-2 fs-6 shadow-sm
                            @if($application['status']['status_name'] == 'Aprobado') bg-success
                            @elseif($application['status']['status_name'] == 'Rechazado') bg-danger
                            @elseif($application['status']['status_name'] == 'Pendiente') bg-warning text-dark
                            @else bg-secondary @endif">
                            {{ $application['status']['status_name'] }}
                        </span>
                    </div>
                </div>
                
                <hr style="border-color: var(--color-verde-suave);">

                <form action="{{ route('admin.applications.volunteer.updateStatus', $application['id_volunteer_applications']) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="id_status" class="form-label fw-bold small text-muted">CAMBIAR ESTADO</label>
                        <select name="id_status" id="id_status" class="form-select form-select-custom w-100" required>
                            @foreach($statuses as $status)
                                <option value="{{ $status['id_status'] }}" 
                                    {{ $status['id_status'] == $application['id_status'] ? 'selected' : '' }}>
                                    {{ $status['status_name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="admin_notes" class="form-label fw-bold small text-muted">NOTAS INTERNAS</label>
                        <textarea name="admin_notes" id="admin_notes" class="form-control form-control-custom w-100" rows="5" 
                            placeholder="Notas de entrevista, disponibilidad, razones...">{{ $application['admin_notes'] ?? '' }}</textarea>
                        <div class="form-text text-end fst-italic small mt-1">Visible solo para administradores.</div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn-cta">
                            <i class="bi bi-save me-2"></i>Actualizar Solicitud
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection