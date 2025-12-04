{{-- resources/views/admin/applications/donation/review.blade.php --}}

@extends('layouts.app') 

@section('title', 'Revisar Solicitud de Donación')

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
        overflow-wrap: break-word; /* Protección contra textos largos */
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

    /* === ICONOS CIRCULARES PERFECTOS === */
    .icon-circle {
        width: 60px;          /* Ancho fijo */
        height: 60px;         /* Alto fijo igual al ancho */
        border-radius: 50%;   /* Círculo perfecto */
        display: inline-flex; 
        align-items: center;  /* Centrado vertical */
        justify-content: center; /* Centrado horizontal */
        background-color: var(--color-verde-suave);
        color: var(--color-verde-oscuro);
        flex-shrink: 0;       
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
        
        /* Corrección para textos largos */
        overflow-wrap: break-word;
        word-wrap: break-word;
        word-break: break-word;
        hyphens: auto;
    }
    .data-value:last-child { border-bottom: none; margin-bottom: 0; }

    /* === ITEM DE DONACIÓN === */
    .donation-item {
        background-color: var(--color-fondo-crema);
        border: 1px solid var(--color-verde-suave);
        border-radius: 15px;
        padding: 15px;
        margin-bottom: 10px;
        transition: all 0.2s ease;
    }
    .donation-item:hover {
        border-color: var(--color-verde-principal);
        transform: translateX(5px);
    }

    /* === FORMULARIOS === */
    .form-select-custom, .form-control-custom {
        border-radius: 20px; border: 2px solid var(--color-verde-suave); padding: 12px 20px;
    }
    .form-select-custom:focus, .form-control-custom:focus {
        border-color: var(--color-verde-principal); box-shadow: 0 0 0 4px rgba(116, 198, 157, 0.2);
    }

    /* === BLOBS === */
    .blob { position: absolute; border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%; filter: blur(60px); z-index: -1; animation: float 8s ease-in-out infinite; }
    .blob-1 { top: -10%; right: -5%; width: 400px; height: 400px; background-color: var(--color-verde-suave); opacity: 0.7; }
    .blob-2 { bottom: 5%; left: -5%; width: 300px; height: 300px; background-color: #95D5B2; opacity: 0.5; animation-delay: 2s; }
    @keyframes float { 0% { transform: translate(0, 0); } 50% { transform: translate(20px, 30px); } 100% { transform: translate(0, 0); } }
</style>

<div class="blob blob-1"></div>
<div class="blob blob-2"></div>

<div class="container pt-5 pb-5 position-relative" style="z-index: 5;">
    
    <!-- Encabezado -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5">
        <div>
            <h1 class="hero-title display-5 mb-2">Solicitud de <span class="highlight-shape">Donación</span></h1>
            <p class="text-muted mb-0 lead" style="font-size: 1.1rem;">
                Revisión del Ticket <strong>#{{ $application['id_donation_application'] }}</strong>
            </p>
        </div>
        <a href="{{ url()->previous() }}" class="text-decoration-none fw-bold mt-3 mt-md-0" style="color: var(--color-acento);">
            <i class="bi bi-arrow-left-circle me-1"></i> Volver al listado
        </a>
    </div>

    <div class="row g-4">
        {{-- Columna Izquierda: Detalles --}}
        <div class="col-lg-8">
            <div class="d-flex flex-column gap-4">
                
                {{-- Tarjeta del Donante --}}
                <div class="feature-card">
                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom" style="border-color: var(--color-verde-suave) !important;">
                        <!-- Icono corregido con .icon-circle -->
                        <div class="icon-circle me-3">
                            <i class="bi bi-person-heart fs-3"></i>
                        </div>
                        <h4 class="fw-bold mb-0 text-dark">Información del Donante</h4>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="data-label">Nombre Completo</div>
                            <div class="data-value">
                                {{ $application['user']['first_name'] }} {{ $application['user']['last_name'] }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="data-label">Correo Electrónico</div>
                            <div class="data-value">
                                {{ $application['user']['email'] }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tarjeta de Artículos --}}
                <div class="feature-card">
                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom" style="border-color: var(--color-verde-suave) !important;">
                        <!-- Icono corregido con .icon-circle (variante color naranja manual si se desea, o verde por defecto) -->
                        <div class="icon-circle me-3" style="background-color: #FFF3E0; color: #F57F17;">
                            <i class="bi bi-box2-heart fs-3"></i>
                        </div>
                        <h4 class="fw-bold mb-0 text-dark">Artículos Ofrecidos</h4>
                    </div>

                    @if(count($application['items']) > 0)
                        <div class="row">
                            @foreach($application['items'] as $item)
                                <div class="col-12">
                                    <div class="donation-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-check-circle-fill me-3 text-success"></i>
                                            <span class="fw-bold fs-5" style="color: var(--color-verde-oscuro);">
                                                {{ $item['item_name'] }}
                                            </span>
                                        </div>
                                        <span class="badge rounded-pill px-3 py-2 fs-6 shadow-sm" style="background-color: var(--color-verde-principal);">
                                            Cantidad: {{ $item['pivot']['quantity'] }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-basket fs-1 d-block mb-2 opacity-50"></i>
                            No hay artículos listados en esta solicitud.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Columna Derecha: Acciones --}}
        <div class="col-lg-4">
            <div class="feature-card sticky-top" style="top: 20px; z-index: 10;">
                <div class="text-center mb-4">
                    <!-- Icono corregido con .icon-circle y centrado mx-auto -->
                    <div class="icon-circle mx-auto mb-3">
                        <i class="bi bi-clipboard-data-fill fs-2"></i>
                    </div>
                    <h5 class="fw-bold">Gestionar Donación</h5>
                    <p class="text-muted small">Actualiza el estado para coordinar la entrega.</p>
                </div>

                <div class="mb-4 text-center">
                    <span class="text-uppercase fw-bold text-muted" style="font-size: 0.75rem; letter-spacing: 1px;">Estado Actual</span>
                    <div class="mt-2">
                        <span class="badge rounded-pill px-4 py-2 fs-6 shadow-sm
                            @if($application['status']['status_name'] == 'Aprobado') bg-success
                            @elseif($application['status']['status_name'] == 'Rechazado') bg-danger
                            @else bg-warning text-dark @endif">
                            {{ $application['status']['status_name'] }}
                        </span>
                    </div>
                </div>
                
                <hr style="border-color: var(--color-verde-suave);">

                <form action="{{ route('admin.applications.donation.updateStatus', $application['id_donation_application']) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="id_status" class="form-label fw-bold small text-muted">CAMBIAR ESTADO</label>
                        <select name="id_status" id="id_status" class="form-select form-select-custom w-100" required>
                            @foreach($statuses as $status)
                                <option value="{{ $status['id_status'] }}" {{ $status['id_status'] == $application['id_status'] ? 'selected' : '' }}>
                                    {{ $status['status_name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="admin_notes" class="form-label fw-bold small text-muted">NOTAS</label>
                        <textarea name="admin_notes" id="admin_notes" class="form-control form-control-custom w-100" rows="5" placeholder="Ej: Podemos recibir la donación el día lunes...">{{ $application['admin_notes'] }}</textarea>
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