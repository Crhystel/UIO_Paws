@extends('layouts.app')

@section('title', 'Revisar Solicitudes')

@section('content')

<!-- 1. FUENTES E ICONOS -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- 2. ESTILOS VISUALES (Mismo diseño que Usuario) -->
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

    /* === TÍTULOS === */
    .hero-title { font-weight: 800; color: var(--color-verde-oscuro); }
    
    .highlight-shape { position: relative; z-index: 1; display: inline-block; }
    .highlight-shape::after {
        content: ''; position: absolute; bottom: 8px; left: -5px; width: 105%; height: 15px;
        background-color: var(--color-verde-principal); opacity: 0.5; 
        border-radius: 20px; z-index: -1; transform: rotate(-1deg);
    }

    /* === TARJETA CONTENEDORA === */
    .feature-card {
        background: white; border-radius: 30px; padding: 30px;
        border: 1px solid rgba(116, 198, 157, 0.1); 
        box-shadow: 0 10px 30px rgba(27, 67, 50, 0.03);
        min-height: 500px; /* Un poco más alto para el admin */
    }

    /* === PESTAÑAS PERSONALIZADAS (Nav Pills) === */
    .nav-pills-custom .nav-link {
        color: var(--color-verde-oscuro);
        background: rgba(255,255,255,0.6);
        border: 1px solid rgba(116, 198, 157, 0.3);
        border-radius: 50px;
        padding: 12px 30px;
        margin-right: 15px;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-bottom: 10px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .nav-pills-custom .nav-link:hover {
        background: var(--color-verde-suave);
        transform: translateY(-2px);
    }

    .nav-pills-custom .nav-link.active {
        background: linear-gradient(135deg, var(--color-verde-principal), var(--color-acento));
        color: white;
        border-color: transparent;
        box-shadow: 0 5px 15px rgba(116, 198, 157, 0.4);
    }

    /* Badge dentro de las pestañas */
    .nav-pills-custom .nav-link .badge {
        background-color: rgba(255,255,255,0.3) !important;
        color: inherit;
        border-radius: 50%;
        padding: 0.5em 0.7em;
        font-size: 0.75em;
    }
    .nav-pills-custom .nav-link.active .badge {
        background-color: rgba(255,255,255,0.2) !important;
        color: white;
    }

    /* === ESTILOS PARA LAS TABLAS (Aplicar a los partials) === */
    .table-custom {
        width: 100%;
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0 10px; /* Espacio entre filas */
    }
    .table-custom thead th {
        border: none;
        color: var(--color-acento);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--color-verde-suave);
    }
    .table-custom tbody tr {
        background-color: white;
        transition: transform 0.2s;
    }
    .table-custom tbody tr:hover {
        transform: scale(1.01);
        background-color: #fcfcfc;
    }
    .table-custom td {
        vertical-align: middle;
        padding: 15px;
        border-top: 1px solid #eee;
        border-bottom: 1px solid #eee;
    }
    .table-custom td:first-child { border-left: 1px solid #eee; border-top-left-radius: 15px; border-bottom-left-radius: 15px; }
    .table-custom td:last-child { border-right: 1px solid #eee; border-top-right-radius: 15px; border-bottom-right-radius: 15px; }

    /* === BLOBS === */
    .blob { position: absolute; border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%; filter: blur(60px); z-index: -1; opacity: 0.6; }
    .blob-1 { top: -10%; left: -10%; width: 500px; height: 500px; background-color: var(--color-verde-suave); }
    .blob-2 { bottom: -10%; right: -10%; width: 400px; height: 400px; background-color: #95D5B2; }

</style>

<!-- Blobs de fondo -->
<div class="blob blob-1"></div>
<div class="blob blob-2"></div>

<div class="container pt-5 pb-5 position-relative" style="z-index: 5;">
    
    <!-- Encabezado y Botón de Volver -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5">
        <div>
            <h1 class="hero-title display-5 mb-2">
                Gestión de <span class="highlight-shape">Solicitudes</span>
            </h1>
            <p class="text-muted mb-0 lead" style="font-size: 1.1rem;">Panel administrativo de adopciones, donaciones y voluntariado.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="text-decoration-none fw-bold mt-3 mt-md-0" style="color: var(--color-acento);">
            <i class="bi bi-arrow-left-circle me-1"></i> Volver al Panel
        </a>
    </div>

    <!-- PESTAÑAS DE NAVEGACIÓN (Diseño Pill) -->
    <ul class="nav nav-pills nav-pills-custom mb-4" id="applicationTabs" role="tablist">
        {{-- Tab Adopciones --}}
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="adoptions-tab-button" data-bs-toggle="pill" data-bs-target="#adoptions-tab-pane" type="button" role="tab" aria-controls="adoptions-tab-pane" aria-selected="true">
                <i class="bi bi-house-heart-fill"></i> Adopciones 
                <span class="badge">{{ $adoptionsPaginator['total'] ?? 0 }}</span>
            </button>
        </li>
        {{-- Tab Donaciones --}}
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="donations-tab-button" data-bs-toggle="pill" data-bs-target="#donations-tab-pane" type="button" role="tab" aria-controls="donations-tab-pane" aria-selected="false">
                <i class="bi bi-box2-heart-fill"></i> Donaciones 
                <span class="badge">{{ $donationsPaginator['total'] ?? 0 }}</span>
            </button>
        </li>
        {{-- Tab Voluntariado --}}
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="volunteers-tab-button" data-bs-toggle="pill" data-bs-target="#volunteers-tab-pane" type="button" role="tab" aria-controls="volunteers-tab-pane" aria-selected="false">
                <i class="bi bi-person-badge-fill"></i> Voluntariado 
                <span class="badge">{{ $volunteersPaginator['total'] ?? 0 }}</span>
            </button>
        </li>
    </ul>

    <!-- CONTENEDOR DE CONTENIDO (Feature Card) -->
    <div class="feature-card">
        <div class="tab-content" id="applicationTabsContent">
            
            {{-- Panel Adopciones --}}
            <div class="tab-pane fade show active" id="adoptions-tab-pane" role="tabpanel" tabindex="0">
                <div class="table-responsive">
                    {{-- 
                       NOTA: Para que la tabla se vea con el diseño nuevo,
                       asegúrate de agregar la clase 'table table-custom' 
                       dentro de tu archivo partial: adoptions-table.blade.php 
                    --}}
                    @include('admin.applications.partials.adoptions-table', ['applications' => $adoptions])
                </div>
            </div>

            {{-- Panel Donaciones --}}
            <div class="tab-pane fade" id="donations-tab-pane" role="tabpanel" tabindex="0">
                <div class="table-responsive">
                    @include('admin.applications.partials.donations-table', ['applications' => $donations])
                </div>
            </div>

            {{-- Panel Voluntariado --}}
            <div class="tab-pane fade" id="volunteers-tab-pane" role="tabpanel" tabindex="0">
                <div class="table-responsive">
                    @include('admin.applications.partials.volunteers-table', ['applications' => $volunteers])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection