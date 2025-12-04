@extends('layouts.app') 

@section('title', 'Conoce a ' . $animal['animal_name'])

@section('content')

<!-- ========================================== -->
<!-- 1. ESTILOS VISUALES (Mismo tema Welcome)   -->
<!-- ========================================== -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
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
        overflow-x: hidden; 
    }

    /* Títulos */
    .hero-title { font-weight: 800; color: var(--color-verde-oscuro); }
    
    /* Subrayado orgánico */
    .highlight-shape { position: relative; z-index: 1; display: inline-block; }
    .highlight-shape::after {
        content: ''; position: absolute; bottom: 5px; left: -5px; width: 105%; height: 15px;
        background-color: var(--color-verde-principal); opacity: 0.5; 
        border-radius: 20px; z-index: -1; transform: rotate(-1deg);
    }

    /* Botón Principal */
    .btn-cta {
        background: linear-gradient(135deg, var(--color-verde-principal), var(--color-acento));
        color: white; padding: 12px 30px; border-radius: 50px;
        font-weight: 700; border: none;
        box-shadow: 0 10px 25px rgba(116, 198, 157, 0.4);
        transition: all 0.3s ease; text-decoration: none; display: inline-block; text-align: center;
    }
    .btn-cta:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 15px 35px rgba(116, 198, 157, 0.6);
        color: white;
    }

    /* Botón Secundario */
    .btn-secondary-custom {
        background-color: white; border: 2px solid var(--color-verde-principal);
        color: var(--color-verde-oscuro); padding: 12px 30px; border-radius: 50px;
        font-weight: 700; text-decoration: none; transition: all 0.3s ease;
        display: inline-block; text-align: center;
    }
    .btn-secondary-custom:hover {
        background-color: var(--color-verde-principal); color: white; transform: translateY(-2px);
    }

    /* Tarjetas Redondeadas */
    .feature-card {
        background: white; border-radius: 30px; padding: 30px;
        border: 1px solid rgba(116, 198, 157, 0.1); 
        box-shadow: 0 10px 30px rgba(27, 67, 50, 0.03);
    }

    /* Imágenes Redondeadas */
    .img-rounded-custom {
        border-radius: 30px;
        box-shadow: 0 10px 30px rgba(27, 67, 50, 0.1);
        object-fit: cover;
    }

    /* Badges personalizados */
    .badge-custom {
        padding: 0.6em 1em; border-radius: 30px; font-weight: 600; letter-spacing: 0.5px;
    }

    /* Lista de detalles */
    .detail-item {
        border-bottom: 1px dashed rgba(116, 198, 157, 0.3);
        padding: 12px 0;
        display: flex; align-items: center; justify-content: space-between;
    }
    .detail-item:last-child { border-bottom: none; }
    .detail-label { font-weight: 600; color: var(--color-acento); display: flex; align-items: center; gap: 8px; }

    /* Acordeón Historial Médico */
    .accordion-custom .accordion-item {
        border: none; border-radius: 20px !important; margin-bottom: 15px;
        background: white; box-shadow: 0 5px 15px rgba(0,0,0,0.03); overflow: hidden;
    }
    .accordion-custom .accordion-button {
        background-color: white; color: var(--color-verde-oscuro); font-weight: 600; border-radius: 20px !important;
        box-shadow: none;
    }
    .accordion-custom .accordion-button:not(.collapsed) {
        background-color: var(--color-verde-suave); color: var(--color-verde-oscuro);
    }
    .accordion-custom .accordion-button:focus { box-shadow: none; border-color: rgba(0,0,0,0.1); }
    
    /* Blobs */
    .blob { position: absolute; border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%; filter: blur(60px); z-index: -1; opacity: 0.6; }
    .blob-1 { top: 10%; left: -10%; width: 400px; height: 400px; background-color: var(--color-verde-suave); }
    .blob-2 { bottom: 20%; right: -10%; width: 300px; height: 300px; background-color: #95D5B2; }

</style>

<!-- Blobs de fondo -->
<div class="blob blob-1"></div>
<div class="blob blob-2"></div>

<div class="container pt-4 pb-5 position-relative" style="z-index: 5;">
    
    <!-- Botón Volver -->
    <div class="mb-4">
        <a href="{{ route('public.animals.index') }}" class="text-decoration-none fw-bold" style="color: var(--color-acento);">
            <i class="bi bi-arrow-left"></i> Volver al listado
        </a>
    </div>

    <div class="row g-4">
        
        {{-- COLUMNA DE FOTOS --}}
        <div class="col-lg-7">
            {{-- Foto Principal --}}
            @if(isset($animal['photos']) && count($animal['photos']) > 0)
                <div class="mb-3 position-relative">
                    <img src="{{ env('API_URL') . $animal['photos'][0]['full_image_url'] }}" 
                         class="img-fluid w-100 img-rounded-custom" 
                         alt="Foto principal de {{ $animal['animal_name'] }}">
                </div>
                
                {{-- Galería de fotos adicionales --}}
                @if(count($animal['photos']) > 1)
                    <div class="row g-2">
                        @foreach(array_slice($animal['photos'], 1) as $photo)
                            <div class="col-3 col-sm-3">
                                <a href="{{ asset('storage/' . $photo['image_url']) }}" data-lightbox="gallery">
                                    <div class="ratio ratio-1x1">
                                        <img src="{{ asset('storage/' . $photo['image_url']) }}" 
                                             class="img-fluid w-100 h-100 object-fit-cover" 
                                             style="border-radius: 20px; cursor: pointer; border: 2px solid white; box-shadow: 0 5px 15px rgba(0,0,0,0.05);"
                                             alt="Foto de {{ $animal['animal_name'] }}">
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            @else
                <div class="feature-card text-center py-5">
                    <i class="bi bi-image text-muted fs-1 opacity-50"></i>
                    <p class="mt-3 text-muted">Este animalito aún no tiene foto.</p>
                </div>
            @endif
        </div>

        {{-- COLUMNA DE INFORMACIÓN --}}
        <div class="col-lg-5">
            <div class="feature-card h-100">
                
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h1 class="hero-title mb-0">{{ $animal['animal_name'] }}</h1>
                    <!-- Icono decorativo -->
                    <i class="bi bi-paw-fill fs-3" style="color: var(--color-verde-principal); opacity: 0.5;"></i>
                </div>

                {{-- Estado de Adopción (Diseño Badge) --}}
                <div class="mb-4">
                    @if($animal['status'] == 'Disponible')
                        <span class="badge bg-success badge-custom">
                            <i class="bi bi-check-circle-fill me-1"></i> Disponible
                        </span>
                    @elseif($animal['status'] == 'En proceso')
                        <span class="badge bg-warning text-dark badge-custom">
                            <i class="bi bi-hourglass-split me-1"></i> En proceso
                        </span>
                    @else
                        <span class="badge bg-secondary badge-custom">Adoptado</span>
                    @endif
                </div>

                <p class="text-muted mb-4" style="line-height: 1.6;">
                    {{ $animal['description'] }}
                </p>

                <!-- Lista de Detalles Estilizada -->
                <div class="mb-4">
                    <div class="detail-item">
                        <span class="detail-label"><i class="bi bi-cake2"></i> Edad</span>
                        <span>{{ $animal['age'] }} años</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label"><i class="bi bi-gender-ambiguous"></i> Sexo</span>
                        <span>{{ $animal['sex'] }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label"><i class="bi bi-aspect-ratio"></i> Tamaño</span>
                        <span>{{ $animal['size'] }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label"><i class="bi bi-tags"></i> Raza</span>
                        <span class="text-end">{{ $animal['breed']['breed_name'] }} <small class="text-muted d-block" style="font-size: 0.8em;">({{ $animal['breed']['species']['species_name'] }})</small></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label"><i class="bi bi-house-heart"></i> Refugio</span>
                        <span>{{ $animal['shelter']['shelter_name'] }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label"><i class="bi bi-bandaid"></i> Esterilizado</span>
                        <span>{{ $animal['is_sterilized'] ? 'Sí' : 'No' }}</span>
                    </div>
                </div>

                {{-- Botones de Acción --}}
                @if($animal['status'] == 'Disponible')
                    <div class="mt-auto pt-2">
                        @auth
                            {{-- USUARIO LOGUEADO --}}
                            <a href="{{ route('adoption.form', $animal['id_animal']) }}" class="btn-cta w-100 fs-5 shadow-lg">
                                ¡Adóptame! <i class="bi bi-heart-fill ms-2"></i>
                            </a>
                        @endauth

                        @guest
                            {{-- USUARIO NO LOGUEADO --}}
                            <div class="text-center p-3 rounded-4" style="background-color: var(--color-verde-suave);">
                                <p class="small fw-bold mb-2 text-muted">¿Te enamoraste?</p>
                                <a href="{{ route('adoption.form', $animal['id_animal']) }}" class="btn-cta w-100">
                                    Adoptar
                                </a>
                            </div>
                        @endguest
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- HISTORIAL MÉDICO --}}
    <div class="row mt-5">
        <div class="col-12">
            <div class="feature-card">
                <div class="mb-4 border-bottom pb-2">
                    <h3 class="fw-bold" style="color: var(--color-verde-oscuro);">
                        Historial <span class="highlight-shape">Médico</span>
                    </h3>
                </div>
                
                <div class="accordion accordion-custom" id="medicalHistory">
                    @forelse($animal['medical_records'] as $index => $record)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $index }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="false" aria-controls="collapse{{ $index }}">
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="badge bg-light text-dark border">{{ \Carbon\Carbon::parse($record['event_date'])->format('d/m/Y') }}</span>
                                        <span>{{ $record['event_type'] }}</span>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $index }}" data-bs-parent="#medicalHistory">
                                <div class="accordion-body text-muted">
                                    <p class="mb-2">{{ $record['description'] }}</p>
                                    @if($record['veterinarian_name'])
                                        <div class="d-flex align-items-center gap-2 mt-2 pt-2 border-top small">
                                            <i class="bi bi-person-badge text-success"></i>
                                            <span>Atendido por: <strong>{{ $record['veterinarian_name'] }}</strong></span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="bi bi-clipboard2-pulse fs-1 text-muted opacity-25"></i>
                            <p class="text-muted mt-2">No hay registros médicos disponibles para este animal.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection