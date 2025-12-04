@extends('layouts.app')
@section('title', 'Gestión de Animales')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
    }
    .feature-card {
        background: white; border-radius: 30px; padding: 40px;
        border: 1px solid rgba(116, 198, 157, 0.1); 
        box-shadow: 0 10px 30px rgba(27, 67, 50, 0.05);
    }
    .hero-title { font-weight: 800; color: var(--color-verde-oscuro); }
    .btn-cta {
        background: linear-gradient(135deg, var(--color-verde-principal), var(--color-acento));
        color: white; padding: 12px 30px; border-radius: 50px; font-weight: 700;
        border: none; box-shadow: 0 10px 25px rgba(116, 198, 157, 0.4);
        transition: all 0.3s ease; text-decoration: none; display: inline-block;
    }
    .btn-cta:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(116, 198, 157, 0.5); }
    .table th { color: var(--color-acento); font-weight: 600; text-transform: uppercase; font-size: 0.8rem; border-bottom: 2px solid var(--color-verde-suave); }
    .table td { vertical-align: middle; }
    .pagination .page-link { color: var(--color-acento); border-radius: 15px !important; margin: 0 5px; border:none; background-color: white; }
    .pagination .page-item.active .page-link { background-color: var(--color-verde-principal); color: white; box-shadow: 0 5px 15px rgba(116, 198, 157, 0.5); }
</style>

<div class="container py-5">
    
    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="hero-title h2 mb-0">Gestión de Animales</h1>
        <a href="{{ route('admin.animals.create') }}" class="btn-cta">Añadir Animal</a>
    </div>

    @include('partials.alerts')

    <!-- Tarjeta Contenedora -->
    <div class="feature-card">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Raza</th>
                        <th>Refugio</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($animals as $animal)
                        <tr>
                            <td class="fw-bold">{{ $animal['animal_name'] }}</td>
                            <td>{{ $animal['breed']['breed_name'] }}</td>
                            <td>{{ $animal['shelter']['shelter_name'] }}</td>
                            <td><span class="badge rounded-pill 
                                @switch($animal['status'])
                                    @case('Disponible') bg-success @break
                                    @case('En Proceso') bg-warning text-dark @break
                                    @case('Adoptado') bg-secondary @break
                                @endswitch">{{ $animal['status'] }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('admin.animals.edit', $animal['id_animal']) }}" class="btn btn-sm btn-outline-warning rounded-pill fw-bold">Editar</a>
                                <form action="{{ route('admin.animals.destroy', $animal['id_animal']) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill fw-bold">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">No hay animales registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if (!empty($paginator['links']))
            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    @foreach ($paginator['links'] as $link)
                        <li class="page-item {{ $link['active'] ? 'active' : '' }} {{ $link['url'] == null ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $link['url'] }}">{!! $link['label'] !!}</a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        @endif
    </div>
</div>
@endsection