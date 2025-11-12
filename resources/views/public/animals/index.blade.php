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
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card h-100 shadow-sm animal-card">
                    {{-- Imagen del animal --}}
                    <a href="{{ route('public.animals.show', $animal['id_animal']) }}">
                        @if(!empty($animal['photos']))
                            <img src="{{ asset('storage/' . $animal['photos'][0]['image_url']) }}" class="card-img-top" alt="Foto de {{ $animal['animal_name'] }}">
                        @else
                            {{-- Imagen de reemplazo si no hay foto --}}
                            <img src="https://via.placeholder.com/300x250.png?text=Sin+Foto" class="card-img-top" alt="Sin foto disponible">
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
        @empty
            <div class="col-12 text-center">
                <p>No hay animalitos disponibles para adopción en este momento. ¡Vuelve pronto!</p>
            </div>
        @endforelse
    </div>

    {{-- Paginación (si la API la proporciona) --}}
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
    .animal-card img {
        height: 250px;
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