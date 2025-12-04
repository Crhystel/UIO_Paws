@extends('layouts.app')

@section('title', 'Encuentra tu compañero ideal')

@section('content')

<!-- ========================================== -->
<!-- 1. ESTILOS EXACTOS DEL WELCOME             -->
<!-- ========================================== -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700;800&display=swap" rel="stylesheet">

<style>
    /* ... (Mismos estilos CSS de antes, sin cambios aquí) ... */
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
        overflow-x: hidden;
        background-image: radial-gradient(rgba(116, 198, 157, 0.4) 1.5px, transparent 1.5px);
        background-size: 30px 30px;
        background-attachment: fixed;
    }

    .hero-title {
        font-weight: 800;
        line-height: 1.1;
        color: var(--color-verde-oscuro);
    }

    .highlight-shape {
        position: relative; z-index: 1; display: inline-block;
    }
    .highlight-shape::after {
        content: ''; position: absolute; bottom: 8px; left: -5px; width: 105%; height: 25px;
        background-color: var(--color-verde-principal); opacity: 0.5; 
        border-radius: 20px; z-index: -1; transform: rotate(-2deg);
    }

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

    .btn-secondary-custom {
        background-color: rgba(255, 255, 255, 0.8);
        border: 2px solid var(--color-verde-oscuro);
        color: var(--color-verde-oscuro); padding: 10px 25px; border-radius: 50px;
        font-weight: 700; text-decoration: none; transition: all 0.3s ease;
        display: inline-block; text-align: center;
    }
    .btn-secondary-custom:hover {
        background-color: var(--color-verde-oscuro); color: white;
        transform: translateY(-2px);
    }

    .feature-card {
        background: white; 
        border-radius: 30px; 
        padding: 30px;
        height: 100%;
        transition: transform 0.3s ease;
        border: 1px solid rgba(116, 198, 157, 0.1); 
        box-shadow: 0 10px 30px rgba(27, 67, 50, 0.03);
        overflow: hidden; 
    }

    .feature-card:hover {
        transform: translateY(-10px);
        border-color: var(--color-verde-principal);
        box-shadow: 0 20px 40px rgba(116, 198, 157, 0.2);
    }

    .blob {
        position: absolute; border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
        filter: blur(60px); z-index: -1; animation: float 8s ease-in-out infinite;
    }
    .blob-1 { top: -10%; right: -10%; width: 500px; height: 500px; background-color: var(--color-verde-suave); opacity: 0.8; }
    .blob-2 { bottom: 10%; left: -5%; width: 350px; height: 350px; background-color: #95D5B2; opacity: 0.5; animation-delay: 2s; }
    
    @keyframes float { 0% { transform: translate(0, 0); } 50% { transform: translate(20px, 30px); } 100% { transform: translate(0, 0); } }

    .form-control-rounded, .form-select-rounded {
        border-radius: 50px; 
        border: 1px solid #ddd;
        padding: 10px 20px;
    }
    .form-control-rounded:focus, .form-select-rounded:focus {
        border-color: var(--color-verde-principal);
        box-shadow: 0 0 0 3px rgba(116, 198, 157, 0.2);
    }
    
    .pagination .page-link {
        border-radius: 50%; width: 40px; height: 40px;
        display: flex; align-items: center; justify-content: center;
        border: none; color: var(--color-verde-oscuro); margin: 0 5px;
        background: white; box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    .pagination .active .page-link {
        background-color: var(--color-verde-principal); color: white;
    }
</style>

<!-- ========================================== -->
<!-- 2. ESTRUCTURA HTML AJUSTADA                -->
<!-- ========================================== -->

<!-- Blobs de fondo -->
<div class="blob blob-1"></div>
<div class="blob blob-2"></div>

<!-- CAMBIO 1: Cambié 'py-5' por 'pb-5 pt-3'. Esto reduce mucho el espacio superior pero mantiene el inferior -->
<div class="container pb-5 pt-3" style="position: relative; z-index: 5;">
    
    <!-- CAMBIO 2: Eliminé la clase 'mt-4' que añadía margen extra arriba -->
    <div class="text-center mb-5">
        <h1 class="hero-title display-4 mb-3">
            Adopta, <span class="highlight-shape">no compres.</span>
        </h1>
        <p class="lead" style="font-weight: 500; opacity: 0.75;">
            Miles de historias esperan un nuevo comienzo.
        </p>
    </div>

    <div class="row g-4">
        <!-- COLUMNA DE FILTROS -->
        <div class="col-lg-3">
            <div class="feature-card pt-4 sticky-top" style="top: 20px; z-index: 10;">
                <h4 class="fw-bold mb-4" style="color: var(--color-verde-oscuro);">
                    <i class="bi bi-funnel"></i> Filtros
                </h4>
                
                <form action="{{ route('public.animals.index') }}" method="GET" id="filterForm">
                    
                    <!-- Buscador -->
                    <div class="mb-3">
                        <label class="small fw-bold text-uppercase mb-1" style="color: var(--color-acento);">Nombre</label>
                        <input type="text" name="animal_name" class="form-control form-control-rounded" placeholder="Ej. Max" value="{{ request('animal_name') }}">
                    </div>

                    <!-- Especie -->
                    <div class="mb-3">
                        <label class="small fw-bold text-uppercase mb-1" style="color: var(--color-acento);">Especie</label>
                        <select name="id_species" class="form-select form-select-rounded" onchange="this.form.submit()">
                            <option value="">Todas</option>
                            @foreach($species as $specie)
                                <option value="{{ $specie['id_species'] }}" {{ request('id_species') == $specie['id_species'] ? 'selected' : '' }}>
                                    {{ $specie['species_name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tamaño -->
                    <div class="mb-3">
                        <label class="small fw-bold text-uppercase mb-1" style="color: var(--color-acento);">Tamaño</label>
                        <div class="d-flex gap-1 flex-wrap">
                            @foreach(['Pequeño', 'Mediano', 'Grande'] as $size)
                                <input type="radio" class="btn-check" name="size" id="size_{{$size}}" value="{{$size}}" {{ request('size') == $size ? 'checked' : '' }} onchange="this.form.submit()">
                                <label class="btn btn-sm rounded-pill flex-fill" 
                                       style="border: 1px solid var(--color-verde-principal); color: var(--color-verde-oscuro);" 
                                       for="size_{{$size}}">
                                    {{$size}}
                                </label>
                                <style>
                                    .btn-check:checked + label {
                                        background-color: var(--color-verde-principal) !important;
                                        color: white !important;
                                    }
                                </style>
                            @endforeach
                        </div>
                    </div>

                    <!-- Refugio -->
                    <div class="mb-3">
                        <label class="small fw-bold text-uppercase mb-1" style="color: var(--color-acento);">Refugio</label>
                        <select name="id_shelter" class="form-select form-select-rounded">
                            <option value="">Todos</option>
                            @foreach($shelters as $shelter)
                                <option value="{{ $shelter['id_shelter'] }}" {{ request('id_shelter') == $shelter['id_shelter'] ? 'selected' : '' }}>
                                    {{ $shelter['shelter_name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Color -->
                    <div class="mb-4">
                        <label class="small fw-bold text-uppercase mb-1" style="color: var(--color-acento);">Color</label>
                        <input type="text" name="color" class="form-control form-control-rounded" placeholder="Ej. Blanco" value="{{ request('color') }}">
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn-cta w-100">Aplicar</button>
                        @if(request()->hasAny(['animal_name', 'id_species', 'id_breed', 'id_shelter', 'size', 'color']))
                            <a href="{{ route('public.animals.index') }}" class="btn-secondary-custom w-100">Limpiar</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- COLUMNA DE RESULTADOS -->
        <div class="col-lg-9">
            @if(session('error'))
                <div class="alert alert-danger rounded-pill border-0 shadow-sm mb-4 text-center">{{ session('error') }}</div>
            @endif

            <div class="row g-4">
                @forelse ($animals as $animal)
                    <div class="col-md-6 col-xl-4">
                        <!-- Tarjeta con estilo feature-card -->
                        <div class="feature-card p-0 h-100 d-flex flex-column">
                            
                            <div class="position-relative">
                                <!-- Imagen -->
                                <a href="{{ route('public.animals.show', $animal['id_animal']) }}">
                                    @if(!empty($animal['photos']))
                                        <div class="ratio ratio-1x1">
                                            <img src="{{ $apiUrl . '/storage/' . $animal['photos'][0]['image_url'] }}" 
                                                 class="object-fit-cover w-100 h-100" 
                                                 alt="{{ $animal['animal_name'] }}" loading="lazy">
                                        </div>
                                    @else
                                        <div class="ratio ratio-1x1 bg-light d-flex align-items-center justify-content-center text-muted">
                                            <i class="bi bi-camera fs-1" style="color: var(--color-verde-principal);"></i>
                                        </div>
                                    @endif
                                </a>

                                <!-- Badge -->
                                <span class="position-absolute top-0 end-0 m-3 px-3 py-1 bg-white rounded-pill fw-bold shadow-sm" 
                                      style="color: var(--color-verde-oscuro); font-size: 0.8rem;">
                                    {{ $animal['breed']['species']['species_name'] ?? 'Animal' }}
                                </span>
                            </div>
                            
                            <div class="p-4 text-center flex-grow-1 d-flex flex-column justify-content-between">
                                <div>
                                    <h3 class="fw-bold mb-1" style="color: var(--color-verde-oscuro);">{{ $animal['animal_name'] }}</h3>
                                    <p class="text-muted small mb-3">
                                        {{ $animal['size'] }} &bull; {{ $animal['age'] }} años
                                    </p>
                                    
                                    <div class="d-flex justify-content-center align-items-center gap-2 mb-3">
                                        <i class="bi bi-geo-alt-fill" style="color: var(--color-verde-principal);"></i>
                                        <small class="text-muted">{{ Str::limit($animal['shelter']['shelter_name'] ?? 'Refugio', 20) }}</small>
                                    </div>
                                </div>

                                <a href="{{ route('public.animals.show', $animal['id_animal']) }}" class="btn-cta py-2 px-4" style="font-size: 0.9rem;">
                                    Adoptar
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 py-5 text-center">
                        <div class="feature-card d-inline-block">
                            <div class="mb-3 opacity-50">
                                <i class="bi bi-search fs-1" style="color: var(--color-verde-principal);"></i>
                            </div>
                            <h4 class="fw-bold mb-2">Sin resultados</h4>
                            <p class="text-muted mb-3">No encontramos peluditos con esos filtros.</p>
                            <a href="{{ route('public.animals.index') }}" class="btn-cta">Ver todos</a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Paginación -->
            @if(isset($paginator['last_page']) && $paginator['last_page'] > 1)
            <div class="mt-5 d-flex justify-content-center">
                <nav>
                    <ul class="pagination">
                        <li class="page-item {{ ($paginator['current_page'] == 1) ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ route('public.animals.index', array_merge(request()->query(), ['page' => $paginator['current_page'] - 1])) }}">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        </li>
                        <li class="page-item active">
                            <span class="page-link">{{ $paginator['current_page'] }}</span>
                        </li>
                        <li class="page-item {{ ($paginator['current_page'] == $paginator['last_page']) ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ route('public.animals.index', array_merge(request()->query(), ['page' => $paginator['current_page'] + 1])) }}">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endpush