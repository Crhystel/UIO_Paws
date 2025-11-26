@extends('layouts.app') 

@section('title', 'Encuentra tu compañero ideal')

@section('content')
<div class="bg-light py-5">
    <div class="container">
        <!-- Encabezado Hero -->
        <div class="text-center mb-5">
            <h1 class="fw-bold text-primary display-5">Adopta, no compres</h1>
            <p class="lead text-muted">Miles de peludos esperan por una segunda oportunidad.</p>
        </div>

        <div class="row">
            <!-- COLUMNA DE FILTROS (Sidebar) -->
            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm sticky-top" style="top: 20px; z-index: 1;">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h5 class="fw-bold"><i class="bi bi-funnel"></i> Filtros</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('public.animals.index') }}" method="GET" id="filterForm">
                            
                            <!-- Buscador -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted text-uppercase">Nombre</label>
                                <input type="text" name="animal_name" class="form-control" placeholder="Ej. Max..." value="{{ request('animal_name') }}">
                            </div>

                            <!-- Especie (NUEVO) -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted text-uppercase">Especie</label>
                                <select name="id_species" class="form-select" onchange="this.form.submit()">
                                    <option value="">Todas las especies</option>
                                    @foreach($species as $specie)
                                        <option value="{{ $specie['id_species'] }}" {{ request('id_species') == $specie['id_species'] ? 'selected' : '' }}>
                                            {{ $specie['species_name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Tamaño -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted text-uppercase">Tamaño</label>
                                <div class="d-flex gap-2">
                                    @foreach(['Pequeño', 'Mediano', 'Grande'] as $size)
                                        <input type="radio" class="btn-check" name="size" id="size_{{$size}}" value="{{$size}}" {{ request('size') == $size ? 'checked' : '' }} onchange="this.form.submit()">
                                        <label class="btn btn-outline-secondary flex-fill text-truncate" for="size_{{$size}}">{{$size}}</label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Refugio -->
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted text-uppercase">Refugio</label>
                                <select name="id_shelter" class="form-select">
                                    <option value="">Todos los refugios</option>
                                    @foreach($shelters as $shelter)
                                        <option value="{{ $shelter['id_shelter'] }}" {{ request('id_shelter') == $shelter['id_shelter'] ? 'selected' : '' }}>
                                            {{ $shelter['shelter_name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                             
                             <!-- Color -->
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-muted text-uppercase">Color</label>
                                <input type="text" name="color" class="form-control" placeholder="Ej. Blanco" value="{{ request('color') }}">
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary fw-bold">Aplicar Filtros</button>
                                @if(request()->hasAny(['animal_name', 'id_species', 'id_breed', 'id_shelter', 'size', 'color']))
                                    <a href="{{ route('public.animals.index') }}" class="btn btn-light text-muted">Limpiar búsqueda</a>
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
                    @forelse ($animals as $animal)
                        <div class="col-md-6 col-xl-4">
                            <div class="card h-100 border-0 shadow-sm animal-card">
                                <div class="position-relative overflow-hidden">
                                    <!-- Imagen -->
                                    <a href="{{ route('public.animals.show', $animal['id_animal']) }}">
                                        @if(!empty($animal['photos']))
                                            <div class="ratio ratio-4x3">
                                                <img src="{{ $apiUrl . '/storage/' . $animal['photos'][0]['image_url'] }}" 
                                                    class="card-img-top object-fit-cover" 
                                                    alt="{{ $animal['animal_name'] }}" loading="lazy">
                                            </div>
                                        @else
                                            <div class="ratio ratio-4x3 bg-light d-flex align-items-center justify-content-center text-muted">
                                                <i class="bi bi-camera fs-1"></i>
                                            </div>
                                        @endif
                                    </a>

                                    <!-- Badge Flotante: Especie y Raza -->
                                    <span class="badge bg-white text-dark shadow-sm position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill fw-bold" style="font-size: 0.85rem;">
                                        {{-- Especie --}}
                                        <span class="text-primary">{{ $animal['breed']['species']['species_name'] ?? 'Animal' }}</span>
                                        
                                        {{-- Raza (solo si existe) --}}
                                        @if(isset($animal['breed']['breed_name']))
                                            &bull; {{ Str::limit($animal['breed']['breed_name'], 15) }}
                                        @endif
                                    </span>
                                </div>
                                
                                <div class="card-body text-center pt-4">
                                    <h5 class="card-title fw-bold mb-1">{{ $animal['animal_name'] }}</h5>
                                    
                                    {{-- Información secundaria (Tamaño y Edad) --}}
                                    <p class="text-muted small mb-3">
                                        {{ $animal['size'] }} &bull; {{ $animal['age'] }} años
                                    </p>
                                    
                                    <hr class="opacity-10 mx-5 my-3">
                                    
                                    {{-- Ubicación --}}
                                    <div class="d-flex justify-content-center px-3 text-muted small">
                                        <span>
                                            <i class="bi bi-geo-alt-fill text-danger"></i> 
                                            {{ Str::limit($animal['shelter']['shelter_name'] ?? 'Refugio', 25) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="card-footer bg-white border-0 pb-4 pt-0">
                                    <a href="{{ route('public.animals.show', $animal['id_animal']) }}" class="btn btn-outline-primary w-100 rounded-pill fw-bold stretched-link">
                                        Conocer más
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 py-5 text-center">
                            <div class="mb-4">
                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486747.png" alt="No results" width="120" class="opacity-50">
                            </div>
                            <h4 class="text-muted fw-bold">No encontramos coincidencias</h4>
                            <p class="text-muted">Intenta ajustar los filtros para ver más resultados.</p>
                            <a href="{{ route('public.animals.index') }}" class="btn btn-primary px-4 rounded-pill">Ver todos</a>
                        </div>
                    @endforelse
                </div>

                @if(isset($paginator['last_page']) && $paginator['last_page'] > 1)
                <div class="mt-5 d-flex justify-content-center">
                    <nav>
                        <ul class="pagination pagination-lg">
                            <li class="page-item {{ ($paginator['current_page'] == 1) ? 'disabled' : '' }}">
                                <a class="page-link border-0" href="{{ route('public.animals.index', array_merge(request()->query(), ['page' => $paginator['current_page'] - 1])) }}"><i class="bi bi-chevron-left"></i></a>
                            </li>
                            <li class="page-item active">
                                <span class="page-link border-0 bg-primary">{{ $paginator['current_page'] }}</span>
                            </li>
                            <li class="page-item {{ ($paginator['current_page'] == $paginator['last_page']) ? 'disabled' : '' }}">
                                <a class="page-link border-0" href="{{ route('public.animals.index', array_merge(request()->query(), ['page' => $paginator['current_page'] + 1])) }}"><i class="bi bi-chevron-right"></i></a>
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
<style>
    /* Efecto Hover Suave */
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
{{-- Si no tienes Bootstrap Icons, importa el CDN aquí --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
@endpush