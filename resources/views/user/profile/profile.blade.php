@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
<div class="container mt-5">
    <h1>Mi Perfil</h1>
    <p>Gestiona tu información personal y tus contactos de emergencia.</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- SECCIÓN DE CONTACTOS DE EMERGENCIA --}}
    <div class="card mt-4">
        <div class="card-header">
            <h3>Mis Contactos de Emergencia</h3>
        </div>
        <div class="card-body">
            @forelse($contacts as $contact)
                <div class="d-flex justify-content-between align-items-center p-2 border-bottom">
                    <div>
                        <strong>{{ $contact['contact_name'] }}</strong> ({{ $contact['relationship'] }})<br>
                        <span class="text-muted">{{ $contact['contact_phone'] }}</span>
                    </div>
                    <div>
                        <form action="{{ route('user.contacts.destroy', $contact['id_emergency_contacts']) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este contacto?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">Aún no has añadido ningún contacto de emergencia.</p>
            @endforelse
        </div>
    </div>
    
    {{-- SECCIÓN PARA AÑADIR NUEVO CONTACTO --}}
    <div class="card mt-4">
        <div class="card-header">
            <h4>Añadir Nuevo Contacto</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('user.contacts.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="contact_name" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" id="contact_name" name="contact_name" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="contact_phone" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="contact_phone" name="contact_phone" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="relationship" class="form-label">Relación/Parentesco</label>
                        <input type="text" class="form-control" id="relationship" name="relationship" placeholder="Ej: Madre, Amigo, Vecino" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Guardar Contacto</button>
            </form>
        </div>
    </div>
</div>
@endsection