@extends('layouts.app') 

@section('title', 'Ayúdanos a Cuidarlos')

@section('content')
<div class="bg-light py-5">
    <div class="container">
        <!-- Encabezado Hero -->
        <div class="text-center mb-5">
            <h1 class="fw-bold text-primary display-5">Tu ayuda salva vidas</h1>
            <p class="lead text-muted">Cada aporte, grande o pequeño, hace la diferencia para nuestros peludos.</p>
        </div>

        <div class="row">
            <!-- COLUMNA DE FILTROS (Sidebar) -->
            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm sticky-top" style="top: 20px; z-index: 1;">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h5 class="fw-bold"><i class="bi bi-funnel"></i> Filtros</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('public.donations.index') }}" method="GET" id="filterForm">
                            
                            <!-- Buscador (Nombre del artículo) -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted text-uppercase">¿Qué buscas donar?</label>
                                <input type="text" name="search" class="form-control" placeholder="Ej. Croquetas..." value="{{ request('search') }}">
                            </div>

                            <!-- Categoría -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted text-uppercase">Categoría</label>
                                <select name="category" class="form-select" onchange="this.form.submit()">
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
                                <label class="form-label small fw-bold text-muted text-uppercase">Refugio Destino</label>
                                <select name="id_shelter" class="form-select" onchange="this.form.submit()">
                                    <option value="">Cualquier Refugio</option>
                                    @foreach($shelters as $shelter)
                                        <option value="{{ $shelter['id_shelter'] }}" {{ request('id_shelter') == $shelter['id_shelter'] ? 'selected' : '' }}>
                                            {{ $shelter['shelter_name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary fw-bold">Aplicar Filtros</button>
                                @if(request()->hasAny(['search', 'category', 'id_shelter']))
                                    <a href="{{ route('public.donations.index') }}" class="btn btn-light text-muted">Limpiar búsqueda</a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- COLUMNA DE RESULTADOS -->
            <div class="col-lg-9">
                @if(session('error'))
                    <div class="alert alert-danger rounded-3 border-0 shadow-sm mb-4">{{ session('error') }}</div>
                @endif

                <div class="row g-4">
                    @forelse ($items as $item)
                        @php
                            // 1. Preparar datos
                            $rawCategory = $item['category'] ?? 'Otro';
                            $categoryLower = mb_strtolower(trim($rawCategory));
                            $shelterName = $item['shelter']['shelter_name'] ?? 'Todos los refugios';
                            $description = $item['description'] ?? 'Tu aporte es fundamental.';
                            
                            // 2. Iconos
                            $iconClass = match (true) {
                                str_contains($categoryLower, 'alimento') || str_contains($categoryLower, 'comida') => 'bi-egg-fried',
                                str_contains($categoryLower, 'medicina') || str_contains($categoryLower, 'salud') => 'bi-capsule',
                                str_contains($categoryLower, 'juguete') => 'bi-joystick',
                                str_contains($categoryLower, 'manta') || str_contains($categoryLower, 'cama') || str_contains($categoryLower, 'ropa') => 'bi-box-seam-fill',
                                str_contains($categoryLower, 'higiene') || str_contains($categoryLower, 'limpieza') => 'bi-droplet-fill',
                                str_contains($categoryLower, 'correa') || str_contains($categoryLower, 'paseo') => 'bi-tencent-qq',
                                default => 'bi-box2-heart-fill'
                            };

                            // 3. COLOR DEL TEMA (Solo el nombre del color: 'danger', 'warning', etc.)
                            $themeColor = match (true) {
                                str_contains($categoryLower, 'alimento') => 'warning', // Amarillo
                                str_contains($categoryLower, 'medicina') => 'danger',  // Rojo
                                str_contains($categoryLower, 'higiene')  => 'info',    // Cian
                                str_contains($categoryLower, 'juguete')  => 'success', // Verde
                                default => 'primary' // Azul
                            };

                            // 4. Cálculos
                            $goal = $item['quantity_needed'];
                            $collected = $item['collected_quantity'] ?? 0;
                            $remaining = max(0, $goal - $collected);
                            $percent = ($goal > 0) ? ($collected / $goal) * 100 : 0;
                            if($percent > 100) $percent = 100;
                        @endphp

                        <div class="col-md-6 col-xl-4">
                            <div class="card h-100 border-0 shadow-sm animal-card">
                                <div class="position-relative overflow-hidden">
                                    
                                    {{-- ZONA DE IMAGEN / ICONO (CORREGIDO) --}}
                                    <div class="ratio ratio-4x3 bg-light">
                                        {{-- 
                                            CAMBIOS AQUÍ:
                                            1. bg-opacity-10: Hace el fondo muy clarito.
                                            2. bg-{{ $themeColor }}: Aplica el color al fondo GRANDE.
                                        --}}
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-{{ $themeColor }} bg-opacity-10">
                                            
                                            {{-- 
                                                CAMBIOS EN EL ICONO:
                                                1. Quitamos bg-{{...}} (Esto eliminaba el cuadro feo).
                                                2. Ponemos text-{{ $themeColor }}: El icono toma el color pero sin fondo.
                                            --}}
                                            <i class="bi {{ $iconClass }} text-{{ $themeColor }}" style="font-size: 5rem;"></i>
                                        </div>
                                    </div>

                                    {{-- Badge de Categoría --}}
                                    <span class="badge bg-white text-dark shadow-sm position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill fw-bold" style="font-size: 0.85rem;">
                                        {{-- Usamos el color del tema para el texto del badge también --}}
                                        <span class="text-{{ $themeColor }}">{{ $rawCategory }}</span>
                                    </span>
                                </div>
                                
                                <div class="card-body text-center pt-4">
                                    <h5 class="card-title fw-bold mb-1">{{ $item['item_name'] }}</h5>
                                    
                                    <p class="text-muted small mb-3 px-2">
                                        {{ Str::limit($description, 60) }}
                                    </p>
                                    
                                    {{-- BARRA DE PROGRESO DINÁMICA --}}
                                    <div class="px-4 mb-3">
                                        <div class="d-flex justify-content-between small fw-bold text-uppercase text-muted mb-1" style="font-size: 0.7rem;">
                                            <span>Progreso</span>
                                            {{-- Mostramos cuánto falta --}}
                                            <span class="text-primary fw-bold">Faltan: {{ $remaining }}</span>
                                        </div>
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-success" role="progressbar" 
                                                 style="width: {{ $percent }}%" 
                                                 aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-1" style="font-size: 0.65rem;">
                                            <span class="text-muted">Recolectado: {{ $collected }}</span>
                                            <span class="text-muted">Meta: {{ $goal }}</span>
                                        </div>
                                    </div>
                                    
                                    <hr class="opacity-10 mx-5 my-3">
                                    
                                    <div class="d-flex justify-content-center px-3 text-muted small">
                                        <span>
                                            <i class="bi bi-geo-alt-fill text-danger"></i> 
                                            {{ Str::limit($shelterName, 25) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="card-footer bg-white border-0 pb-4 pt-0">
                                    @auth
                                        <a href="{{ route('user.donations.create') }}" class="btn btn-outline-primary w-100 rounded-pill fw-bold stretched-link">
                                            Donar Ahora
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-outline-primary w-100 rounded-pill fw-bold stretched-link">
                                            Login para Donar
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @empty
                        {{-- ESTADO VACÍO (Empty State) --}}
                        <div class="col-12 py-5 text-center">
                            <div class="mb-4">
                                <i class="bi bi-search text-muted opacity-50" style="font-size: 5rem;"></i>
                            </div>
                            <h4 class="text-muted fw-bold">No encontramos coincidencias</h4>
                            <p class="text-muted">Intenta ajustar los filtros para ver más artículos.</p>
                            <a href="{{ route('public.donations.index') }}" class="btn btn-primary px-4 rounded-pill">Ver todos</a>
                        </div>
                    @endforelse
                </div>

                {{-- PAGINACIÓN --}}
                @if(isset($paginator['last_page']) && $paginator['last_page'] > 1)
                <div class="mt-5 d-flex justify-content-center">
                    <nav>
                        <ul class="pagination pagination-lg">
                            <li class="page-item {{ ($paginator['current_page'] == 1) ? 'disabled' : '' }}">
                                <a class="page-link border-0" href="{{ route('public.donations.index', array_merge(request()->query(), ['page' => $paginator['current_page'] - 1])) }}"><i class="bi bi-chevron-left"></i></a>
                            </li>
                            <li class="page-item active">
                                <span class="page-link border-0 bg-primary">{{ $paginator['current_page'] }}</span>
                            </li>
                            <li class="page-item {{ ($paginator['current_page'] == $paginator['last_page']) ? 'disabled' : '' }}">
                                <a class="page-link border-0" href="{{ route('public.donations.index', array_merge(request()->query(), ['page' => $paginator['current_page'] + 1])) }}"><i class="bi bi-chevron-right"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
{{-- IMPORTANTE: Asegura que carguen los iconos --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    .animal-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .animal-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.1)!important;
    }
    .object-fit-cover {
        object-fit: cover;
        width: 100%;
        height: 100%;
    }
</style>
@endpush