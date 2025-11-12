@extends('layouts.app') 

@section('title', 'Conoce a ' . $animal['animal_name'])

@section('content')
<div class="container mt-5">
    <div class="row">
        {{-- Columna de Fotos --}}
        <div class="col-md-7">
            {{-- Foto Principal --}}
            @if(isset($animal['photos']) && count($animal['photos']) > 0)
                <img src="{{ asset('storage/' . $animal['photos'][0]['image_url']) }}" class="img-fluid rounded mb-3" alt="Foto principal de {{ $animal['animal_name'] }}">
                
                {{-- Galería de fotos adicionales --}}
                @if(count($animal['photos']) > 1)
                    <div class="row">
                        @foreach(array_slice($animal['photos'], 1) as $photo)
                            <div class="col-4">
                                <a href="{{ asset('storage/' . $photo['image_url']) }}" data-lightbox="gallery">
                                    <img src="{{ asset('storage/' . $photo['image_url']) }}" class="img-fluid rounded mb-2" alt="Foto de {{ $animal['animal_name'] }}">
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            @else
                <div class="text-center p-5 border rounded bg-light">
                    <p>Este animalito aún no tiene foto.</p>
                </div>
            @endif
        </div>

        {{-- Columna de Información --}}
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title">{{ $animal['animal_name'] }}</h1>
                    
                    {{-- Estado de Adopción --}}
                    @if($animal['status'] == 'Disponible')
                        <span class="badge bg-success fs-6 mb-3">Disponible para adopción</span>
                    @elseif($animal['status'] == 'En proceso')
                        <span class="badge bg-warning text-dark fs-6 mb-3">Solicitud en proceso</span>
                    @else
                        <span class="badge bg-secondary fs-6 mb-3">Adoptado</span>
                    @endif

                    <p class="card-text">{{ $animal['description'] }}</p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><b>Edad:</b> {{ $animal['age'] }} años</li>
                        <li class="list-group-item"><b>Sexo:</b> {{ $animal['sex'] }}</li>
                        <li class="list-group-item"><b>Tamaño:</b> {{ $animal['size'] }}</li>
                        <li class="list-group-item"><b>Raza:</b> {{ $animal['breed']['breed_name'] }} ({{ $animal['breed']['species']['species_name'] }})</li>
                        <li class="list-group-item"><b>Refugio:</b> {{ $animal['shelter']['shelter_name'] }}</li>
                        <li class="list-group-item"><b>Esterilizado:</b> {{ $animal['is_sterilized'] ? 'Sí' : 'No' }}</li>
                    </ul>

                    @if($animal['status'] == 'Disponible')
                        <a href="#" class="btn btn-primary mt-3 w-100">¡Adóptame!</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Historial Médico --}}
    <div class="row mt-5">
        <div class="col-12">
            <h3>Historial Médico</h3>
            <div class="accordion" id="medicalHistory">
                @forelse($animal['medicalRecords'] as $index => $record)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $index }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="false" aria-controls="collapse{{ $index }}">
                                <strong>{{ \Carbon\Carbon::parse($record['event_date'])->format('d/m/Y') }}</strong>: {{ $record['event_type'] }}
                            </button>
                        </h2>
                        <div id="collapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $index }}" data-bs-parent="#medicalHistory">
                            <div class="accordion-body">
                                {{ $record['description'] }}
                                @if($record['veterinarian_name'])
                                    <br><small class="text-muted">Atendido por: {{ $record['veterinarian_name'] }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p>No hay registros médicos disponibles para este animal.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection