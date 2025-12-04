@extends('layouts.app')
@section('title', 'Editar Animal')

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
    <div class="row justify-content-center">
        <div class="col-lg-10">
             <div class="text-center mb-4">
                 <h1 class="hero-title h2 mb-0">Editar Animal</h1>
                 <p class="text-muted fst-italic">"{{ $animal['animal_name'] }}"</p>
            </div>
        
            <div class="feature-card">
                <form action="{{ route('admin.animals.update', $animal['id_animal']) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @include('admin.animals.form', ['animal' => $animal, 'buttonText' => 'Actualizar Animal'])
                </form>
            </div>
            <div class="mt-5">
                <h3 class="hero-title h4">Historial Médico Completo</h3>
                <div class="feature-card mt-3">
                    {{-- Aquí va el código de la tabla y el formulario de añadir registro --}}
                    {{-- Puedes poner el include aquí directamente --}}
                    
                    <div class="table-responsive mb-4">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Evento</th>
                                    <th>Descripción</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($animal['medical_records'] ?? [] as $record)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($record['event_date'])->format('d/m/Y') }}</td>
                                        <td>{{ $record['event_type'] }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($record['description'], 50) }}</td>
                                        <td>
                                            {{-- Formulario 2: Eliminar registro (Independiente) --}}
                                            <form action="{{ route('admin.records.destroy', $record['id_medical_records']) }}" method="POST" onsubmit="return confirm('¿Eliminar este registro?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted">No hay registros médicos.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <h5 class="mt-4">Añadir Nuevo Registro Médico</h5>
                    <form action="{{ route('admin.animals.records.store', ['animal' => $animal['id_animal']]) }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-4"><input type="date" name="event_date" class="form-control rounded-pill" required></div>
                            <div class="col-md-8"><input type="text" name="event_type" class="form-control rounded-pill" placeholder="Tipo de evento" required></div>
                            <div class="col-12"><textarea name="description" class="form-control rounded-3" placeholder="Descripción detallada..." required></textarea></div>
                        </div>
                        <button type="submit" class="btn btn-primary rounded-pill mt-3">Añadir Registro</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection