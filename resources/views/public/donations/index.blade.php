@extends('layouts.app') 

@section('title', 'Ayúdanos a Cuidarlos')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    /* === VARIABLES GLOBALES === */
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

    /* === TIPOGRAFÍA === */
    .hero-title { font-weight: 800; line-height: 1.1; color: var(--color-verde-oscuro); }
    
    .highlight-shape { position: relative; z-index: 1; display: inline-block; }
    .highlight-shape::after {
        content: ''; position: absolute; bottom: 8px; left: -5px; width: 105%; height: 25px;
        background-color: var(--color-verde-principal); opacity: 0.5; 
        border-radius: 20px; z-index: -1; transform: rotate(-2deg);
    }

    /* === TARJETAS === */
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

    /* === BOTONES === */
    .btn-cta {
        background: linear-gradient(135deg, var(--color-verde-principal), var(--color-acento));
        color: white; padding: 10px 25px; border-radius: 50px;
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
        background-color: white; border: 2px solid var(--color-verde-oscuro);
        color: var(--color-verde-oscuro); padding: 8px 20px; border-radius: 50px;
        font-weight: 700; text-decoration: none; transition: all 0.3s ease;
        display: inline-block; text-align: center;
    }
    .btn-secondary-custom:hover {
        background-color: var(--color-verde-oscuro); color: white;
    }

    /* === INPUTS === */
    .form-control-rounded, .form-select-rounded {
        border-radius: 50px; border: 1px solid #ddd; padding: 10px 20px;
    }
    .form-control-rounded:focus, .form-select-rounded:focus {
        border-color: var(--color-verde-principal); box-shadow: 0 0 0 3px rgba(116, 198, 157, 0.2);
    }

    /* === BARRAS DE PROGRESO === */
    .progress-custom {
        height: 12px; border-radius: 20px; background-color: #eee; overflow: hidden;
    }
    .progress-bar-custom {
        background: linear-gradient(90deg, var(--color-verde-principal), var(--color-acento));
    }

    /* === PAGINACIÓN === */
    .pagination .page-link {
        border-radius: 50%; width: 40px; height: 40px;
        display: flex; align-items: center; justify-content: center;
        border: none; color: var(--color-verde-oscuro); margin: 0 5px;
        background: white; box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    .pagination .active .page-link {
        background-color: var(--color-verde-principal); color: white;
    }
    
    /* === ANIMACIÓN DE FONDO === */
    .blob { position: absolute; border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%; filter: blur(60px); z-index: -1; opacity: 0.6; animation: float 8s ease-in-out infinite; }
    .blob-1 { top: -10%; right: -10%; width: 500px; height: 500px; background-color: var(--color-verde-suave); }
    .blob-2 { bottom: 10%; left: -5%; width: 350px; height: 350px; background-color: #95D5B2; animation-delay: 2s; }
    @keyframes float { 0% { transform: translate(0, 0); } 50% { transform: translate(20px, 30px); } 100% { transform: translate(0, 0); } }

</style>

<!-- Blobs de fondo -->
<div class="blob blob-1"></div>
<div class="blob blob-2"></div>

<div class="container pb-5 pt-3 position-relative" style="z-index: 5;">
    
    <!-- Encabezado Hero -->
    <div class="text-center mb-5">
        <h1 class="hero-title display-4 mb-3">
            Tu ayuda <span class="highlight-shape">salva vidas.</span>
        </h1>
        <p class="lead" style="font-weight: 500; opacity: 0.75;">
            Cada aporte, grande o pequeño, hace la diferencia para nuestros peludos.
        </p>
    </div>

    <div class="row g-4">
        <!-- COLUMNA DE FILTROS-->
        <div class="col-lg-3">
            <div class="feature-card pt-4 sticky-top" style="top: 20px; z-index: 10;">
                <h4 class="fw-bold mb-4" style="color: var(--color-verde-oscuro);">
                    <i class="bi bi-funnel"></i> Filtros
                </h4>
                
                <form action="{{ route('public.donations.index') }}" method="GET" id="filterForm">
                    
                    <!-- Buscador -->
                    <div class="mb-3">
                        <label class="small fw-bold text-uppercase mb-1" style="color: var(--color-acento);">¿Qué buscas donar?</label>
                        <input type="text" name="search" class="form-control form-control-rounded" placeholder="Ej. Croquetas..." value="{{ request('search') }}">
                    </div>

                    <!-- Categoría -->
                    <div class="mb-3">
                        <label class="small fw-bold text-uppercase mb-1" style="color: var(--color-acento);">Categoría</label>
                        <select name="category" class="form-select form-select-rounded" onchange="this.form.submit()">
                            <option value="">Todas las categorías</option>
                            @foreach(['Alimento', 'Medicina', 'Juguetes', 'Mantas', 'Higiene', 'Otro'] as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Refugio -->
                    <div class="mb-4">
                        <label class="small fw-bold text-uppercase mb-1" style="color: var(--color-acento);">Refugio Destino</label>
                        <select name="id_shelter" class="form-select form-select-rounded" onchange="this.form.submit()">
                            <option value="">Cualquier Refugio</option>
                            @foreach($shelters as $shelter)
                                <option value="{{ $shelter['id_shelter'] }}" {{ request('id_shelter') == $shelter['id_shelter'] ? 'selected' : '' }}>
                                    {{ $shelter['shelter_name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn-cta w-100">Aplicar</button>
                        @if(request()->hasAny(['search', 'category', 'id_shelter']))
                            <a href="{{ route('public.donations.index') }}" class="btn-secondary-custom w-100">Limpiar</a>
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
                @forelse ($items as $item)
                    @php
                        // Lógica original preservada
                        $rawCategory = $item['category'] ?? 'Otro';
                        $categoryLower = mb_strtolower(trim($rawCategory));
                        $shelterName = $item['shelter']['shelter_name'] ?? 'Todos los refugios';
                        $description = $item['description'] ?? 'Tu aporte es fundamental.';
                        
                        $iconClass = match (true) {
                            str_contains($categoryLower, 'alimento') || str_contains($categoryLower, 'comida') => 'bi-egg-fried',
                            str_contains($categoryLower, 'medicina') || str_contains($categoryLower, 'salud') => 'bi-capsule',
                            str_contains($categoryLower, 'juguete') => 'bi-joystick',
                            str_contains($categoryLower, 'manta') || str_contains($categoryLower, 'cama') || str_contains($categoryLower, 'ropa') => 'bi-box-seam-fill',
                            str_contains($categoryLower, 'higiene') || str_contains($categoryLower, 'limpieza') => 'bi-droplet-fill',
                            str_contains($categoryLower, 'correa') || str_contains($categoryLower, 'paseo') => 'bi-tencent-qq',
                            default => 'bi-box2-heart-fill'
                        };

                        // Colores de tema (Bootstrap colors para los iconos)
                        $themeColor = match (true) {
                            str_contains($categoryLower, 'alimento') => 'warning',
                            str_contains($categoryLower, 'medicina') => 'danger',
                            str_contains($categoryLower, 'higiene')  => 'info',
                            str_contains($categoryLower, 'juguete')  => 'success',
                            default => 'primary'
                        };

                        $goal = $item['quantity_needed'];
                        $collected = $item['collected_quantity'] ?? 0;
                        $remaining = max(0, $goal - $collected);
                        $percent = ($goal > 0) ? ($collected / $goal) * 100 : 0;
                        if($percent > 100) $percent = 100;
                    @endphp

                    <div class="col-md-6 col-xl-4">
                        <div class="feature-card p-0 h-100 d-flex flex-column">
                            
                            <div class="position-relative">
                                {{-- Zona de Icono/Imagen --}}
                                <div class="ratio ratio-4x3 bg-{{ $themeColor }} bg-opacity-10 d-flex align-items-center justify-content-center">
                                    <div class="d-flex align-items-center justify-content-center w-100 h-100">
                                        <i class="bi {{ $iconClass }} text-{{ $themeColor }}" style="font-size: 4.5rem;"></i>
                                    </div>
                                </div>

                                {{-- Badge de Categoría --}}
                                <span class="position-absolute top-0 start-0 m-3 px-3 py-2 bg-white rounded-pill fw-bold shadow-sm" 
                                      style="font-size: 0.8rem; color: var(--color-verde-oscuro);">
                                    {{ $rawCategory }}
                                </span>
                            </div>
                            
                            <div class="p-4 text-center flex-grow-1 d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="fw-bold mb-2" style="color: var(--color-verde-oscuro);">{{ $item['item_name'] }}</h5>
                                    
                                    <p class="text-muted small mb-3">
                                        {{ Str::limit($description, 60) }}
                                    </p>
                                    
                                    {{-- Barra de Progreso --}}
                                    <div class="mb-3 text-start">
                                        <div class="d-flex justify-content-between small fw-bold text-uppercase text-muted mb-1" style="font-size: 0.7rem;">
                                            <span>Progreso</span>
                                            <span style="color: var(--color-acento);">Faltan: {{ $remaining }}</span>
                                        </div>
                                        <div class="progress-custom">
                                            <div class="progress-bar progress-bar-custom" role="progressbar" 
                                                 style="width: {{ $percent }}%" 
                                                 aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-1" style="font-size: 0.65rem;">
                                            <span class="text-muted">Llevamos: {{ $collected }}</span>
                                            <span class="text-muted">Meta: {{ $goal }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-center align-items-center gap-2 mb-3 small text-muted">
                                        <i class="bi bi-geo-alt-fill text-danger"></i> 
                                        <span>{{ Str::limit($shelterName, 20) }}</span>
                                    </div>
                                </div>

                                {{-- Botón de Acción --}}
                                <div>
                                    @auth
                                        <a href="{{ route('user.donations.create', ['preselected_id' => $item['id_donation_item_catalog']]) }}"  class="btn-cta w-100 py-2 shadow-sm" style="font-size: 0.9rem;">
                                            Donar Ahora
                                        </a>
                                    @else
                                        <a href="{{ route('user.donations.create', ['preselected_id' => $item['id_donation_item_catalog']]) }}" class="btn-cta w-100 py-2 shadow-sm" style="font-size: 0.9rem;">
                                            Donar Ahora
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- ESTADO VACÍO --}}
                    <div class="col-12 py-5 text-center">
                        <div class="feature-card d-inline-block">
                            <div class="mb-3 opacity-50">
                                <i class="bi bi-search fs-1" style="color: var(--color-verde-principal);"></i>
                            </div>
                            <h4 class="fw-bold mb-2">No encontramos resultados</h4>
                            <p class="text-muted mb-3">Intenta buscar con otros términos.</p>
                            <a href="{{ route('public.donations.index') }}" class="btn-cta">Ver todo</a>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Paginación --}}
            @if(isset($paginator['last_page']) && $paginator['last_page'] > 1)
            <div class="mt-5 d-flex justify-content-center">
                <nav>
                    <ul class="pagination">
                        <li class="page-item {{ ($paginator['current_page'] == 1) ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ route('public.donations.index', array_merge(request()->query(), ['page' => $paginator['current_page'] - 1])) }}">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        </li>
                        <li class="page-item active">
                            <span class="page-link">{{ $paginator['current_page'] }}</span>
                        </li>
                        <li class="page-item {{ ($paginator['current_page'] == $paginator['last_page']) ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ route('public.donations.index', array_merge(request()->query(), ['page' => $paginator['current_page'] + 1])) }}">
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