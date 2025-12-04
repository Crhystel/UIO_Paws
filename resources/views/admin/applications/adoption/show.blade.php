{{-- resources/views/admin/applications/adoption/review.blade.php --}}

@extends('layouts.app') 

@section('title', 'Revisar Solicitud de Adopción')

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
        overflow-wrap: break-word; /* Evita que textos largos rompan la tarjeta */
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
        width: 70px;          /* Ancho fijo */
        height: 70px;         /* Alto fijo igual al ancho */
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
    .blob-1 { top: -10%; left: -5%; width: 400px; height: 400px; background-color: var(--color-verde-suave); opacity: 0.7; }
    .blob-2 { bottom: 5%; right: -5%; width: 300px; height: 300px; background-color: #95D5B2; opacity: 0.5; animation-delay: 2s; }
    @keyframes float { 0% { transform: translate(0, 0); } 50% { transform: translate(20px, 30px); } 100% { transform: translate(0, 0); } }
</style>

<div class="blob blob-1"></div>
<div class="blob blob-2"></div>

<div class="container pt-5 pb-5 position-relative" style="z-index: 5;">
    
    <!-- Encabezado -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5">
        <div>
            <h1 class="hero-title display-5 mb-2">Revisión de <span class="highlight-shape">Solicitud</span></h1>
            <p class="text-muted mb-0 lead" style="font-size: 1.1rem;">
                Detalles para la adopción de <strong>{{ $application['animal']['animal_name'] }}</strong>
            </p>
        </div>
        <a href="{{ url()->previous() }}" class="text-decoration-none fw-bold mt-3 mt-md-0" style="color: var(--color-acento);">
            <i class="bi bi-arrow-left-circle me-1"></i> Volver al listado
        </a>
    </div>

    <div class="row g-4">
        {{-- Columna Izquierda: Información --}}
        <div class="col-lg-8">
            <div class="d-flex flex-column gap-4">
                
                <div class="row g-4">
                    <!-- Tarjeta Animal -->
                    <div class="col-md-6">
                        <div class="feature-card h-100 position-relative overflow-hidden">
                            <div class="position-absolute top-0 end-0 m-3 opacity-25" style="color: var(--color-verde-principal);">
                                <i class="bi bi-paw-fill fs-1"></i>
                            </div>
                            <h5 class="fw-bold mb-4" style="color: var(--color-verde-oscuro);">
                                <i class="bi bi-info-circle me-2"></i>Información del Animal
                            </h5>
                            <div>
                                <div class="data-label">Nombre</div>
                                <div class="data-value">{{ $application['animal']['animal_name'] }}</div>
                                <div class="data-label mt-3">Raza</div>
                                <div class="data-value">{{ $application['animal']['breed']['breed_name'] ?? 'N/A' }}</div>
                                <div class="data-label mt-3">Edad</div>
                                <div class="data-value">{{ $application['animal']['age'] }} años</div>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta Adoptante -->
                    <div class="col-md-6">
                        <div class="feature-card h-100 position-relative overflow-hidden">
                            <div class="position-absolute top-0 end-0 m-3 opacity-25" style="color: var(--color-acento);">
                                <i class="bi bi-person-heart fs-1"></i>
                            </div>
                            <h5 class="fw-bold mb-4" style="color: var(--color-verde-oscuro);">
                                <i class="bi bi-person-vcard me-2"></i>Datos del Adoptante
                            </h5>
                            <div>
                                <div class="data-label">Solicitante</div>
                                <div class="data-value">{{ $application['user']['first_name'] }} {{ $application['user']['last_name'] }}</div>
                                <div class="data-label mt-3">Email</div>
                                <div class="data-value">{{ $application['user']['email'] }}</div>
                                <div class="data-label mt-3">Teléfono</div>
                                <div class="data-value">{{ $application['user']['phone'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Cuestionario de Adopción --}}
                <div class="feature-card">
                    <h5 class="fw-bold mb-4 border-bottom pb-3" style="border-color: var(--color-verde-suave) !important;">
                        <i class="bi bi-clipboard-check me-2"></i>Cuestionario de Hogar
                    </h5>
                    
                    @php
                        // Diccionario de Traducción Completo
                        $translations = [ 
                            'dwelling_type' => 'Tipo de Vivienda', 
                            'adults_in_home' => 'Adultos en Casa',
                            'wall_material' => 'Material de Paredes',
                            'floor_material' => 'Material de Piso',
                            'room_count' => 'Número de Habitaciones',
                            'bathroom_count' => 'Número de Baños',
                            'has_yard' => '¿Tiene Patio?', 
                            'yard_enclosure_type' => 'Cerramiento del Patio', 
                            'has_balcony' => '¿Tiene Balcón?',
                            'current_pet_count' => 'Mascotas Actuales',
                            'others_pets_description' => 'Descripción Otras Mascotas',
                            'previous_pets_history' => 'Historial de Mascotas',
                            'all_members_agree' => '¿Todos de Acuerdo?', 
                            'motivation_for_adoption' => 'Motivación para Adoptar', 
                            'hours_pet_will_be_alone' => 'Horas Solo/a', 
                            'location_when_alone' => 'Ubicación cuando está solo',
                            'exercise_plan' => 'Plan de Ejercicio', 
                            'vacation_emergency_plan' => 'Plan Vacaciones/Emergencia',
                            'behavioral_issue_plan' => 'Plan de Comportamiento',
                            'vet_reference_name' => 'Veterinario (Nombre)',
                            'vet_reference_phone' => 'Veterinario (Teléfono)'
                        ];

                        // Lista de campos que son estrictamente booleanos (Sí/No)
                        $boolKeys = ['has_yard', 'has_balcony', 'all_members_agree'];
                    @endphp

                    <div class="row">
                        @foreach($application['home_information'] as $key => $value)
                            @if(!in_array($key, ['id_home_info', 'id_adoption_application', 'created_at', 'updated_at']))
                                <div class="col-md-6 mb-3">
                                    {{-- Título del Campo (Traducido) --}}
                                    <div class="data-label">
                                        {{ $translations[$key] ?? ucwords(str_replace('_', ' ', $key)) }}
                                    </div>

                                    {{-- Valor del Campo --}}
                                    <div class="data-value">
                                        {{-- Lógica para detectar Booleanos (incluyendo 1/0 de la BD) --}}
                                        @if(in_array($key, $boolKeys))
                                            @php
                                                // Convertir cualquier formato (1, "1", true) a booleano real
                                                $isYes = ($value == 1 || $value === '1' || $value === true);
                                            @endphp
                                            <span class="badge {{ $isYes ? 'bg-success' : 'bg-secondary' }} rounded-pill px-3">
                                                {{ $isYes ? 'Sí' : 'No' }}
                                            </span>
                                        @elseif(is_null($value) || $value === '')
                                            <span class="text-muted fst-italic">No especificado</span>
                                        @else
                                            {{-- Mostrar valor normal (texto o número) --}}
                                            {{ $value }}
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Columna Derecha: Acciones --}}
        <div class="col-lg-4">
            <div class="feature-card sticky-top" style="top: 20px; z-index: 10;">
                <div class="text-center mb-4">
                    <!-- Icono corregido con clase .icon-circle -->
                    <div class="icon-circle mx-auto mb-3">
                        <i class="bi bi-shield-lock-fill fs-2"></i>
                    </div>
                    <h5 class="fw-bold">Gestión de Solicitud</h5>
                    <p class="text-muted small">Cambia el estado y añade notas para el registro.</p>
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

                <form action="{{ route('admin.applications.adoption.updateStatus', $application['id_adoption_application']) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="id_status" class="form-label fw-bold small text-muted">NUEVO ESTADO</label>
                        <select name="id_status" id="id_status" class="form-select form-select-custom w-100" required>
                            @foreach($statuses as $status)
                                <option value="{{ $status['id_status'] }}" {{ $status['id_status'] == $application['id_status'] ? 'selected' : '' }}>
                                    {{ $status['status_name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="admin_notes" class="form-label fw-bold small text-muted">NOTAS DEL ADMINISTRADOR</label>
                        <textarea name="admin_notes" id="admin_notes" class="form-control form-control-custom w-100" rows="5" placeholder="Escribe aquí las observaciones...">{{ $application['admin_notes'] }}</textarea>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn-cta">
                            <i class="bi bi-save me-2"></i>Actualizar Estado
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection