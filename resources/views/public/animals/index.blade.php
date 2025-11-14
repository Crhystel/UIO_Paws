@extends('layouts.app') 

@section('title', 'Adopta un Amigo')

@section('content')
<div class="container mt-5">
    <div class="text-center mb-5">
        <h1 class="display-4">Conoce a tus Futuros Amigos</h1>
        <p class="lead text-muted">Cada uno de ellos está esperando una segunda oportunidad y un hogar lleno de amor.</p>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        @forelse ($animals as $animal)
            {{-- La columna de Bootstrap sigue siendo la misma --}}
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                {{-- 1. Añadimos un 'wrapper' o envoltorio para controlar el espaciado --}}
                <div class="animal-card-wrapper">
                    <div class="card h-100 shadow-sm animal-card">
                        <a href="{{ route('public.animals.show', $animal['id_animal']) }}" class="animal-card-image-container">
                            @if(!empty($animal['photos']))
                                <img src="{{ config('app.api_url') . $animal['photos'][0]['full_image_url'] }}" 
                                     class="card-img-top" 
                                     alt="Foto de {{ $animal['animal_name'] }}"
                                     loading="lazy">
                            @else
                                <img src="https://via.placeholder.com/1600x900.png?text=Sin+Foto" class="card-img-top" alt="Sin foto disponible">
                            @endif
                        </a>
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $animal['animal_name'] }}</h5>
                            <p class="card-text text-muted small">
                                {{ $animal['breed']['breed_name'] }} &bull; {{ $animal['age'] }} años
                            </p>
                            <a href="{{ route('public.animals.show', $animal['id_animal']) }}" class="btn btn-primary mt-auto">Ver Detalles</a>
                        </div>
                    </div>
                </div>
                {{-- === FIN DEL CAMBIO === --}}

            </div>
        @empty
            <div class="col-12 text-center">
                <p>No hay animalitos disponibles para adopción en este momento. ¡Vuelve pronto!</p>
            </div>
        @endforelse
    </div>

    {{-- Paginación --}}
    @if(isset($paginator) && !empty($paginator['links']))
    <div class="d-flex justify-content-center mt-4">
        <nav>
            <ul class="pagination">
                @foreach ($paginator['links'] as $link)
                    <li class="page-item {{ $link['active'] ? 'active' : '' }} {{ is_null($link['url']) ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $link['url'] }}">{!! $link['label'] !!}</a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
    @endif

</div>
@endsection

@push('styles')
<style>
    .animal-card-wrapper {
        padding: 0 10px;
    }

    .animal-card .animal-card-image-container {
        aspect-ratio: 16 / 9;
        overflow: hidden;
        background-color: #f8f9fa;
    }

    .animal-card .card-img-top {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .animal-card {
        transition: transform .2s ease-in-out, box-shadow .2s ease-in-out;
    }

    .animal-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15)!important;
    }
</style>
@endpush