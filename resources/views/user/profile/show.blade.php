@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    /* === VARIABLES === */
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
    .hero-title { font-weight: 800; color: var(--color-verde-oscuro); }
    
    .highlight-shape { position: relative; z-index: 1; display: inline-block; }
    .highlight-shape::after {
        content: ''; position: absolute; bottom: 8px; left: -5px; width: 105%; height: 15px;
        background-color: var(--color-verde-principal); opacity: 0.5; 
        border-radius: 20px; z-index: -1; transform: rotate(-1deg);
    }

    /* === TARJETAS === */
    .feature-card {
        background: white; border-radius: 30px; padding: 30px;
        border: 1px solid rgba(116, 198, 157, 0.1); 
        box-shadow: 0 10px 30px rgba(27, 67, 50, 0.03);
        height: 100%;
    }

    /* === INPUTS === */
    .form-control-rounded, .form-select-rounded {
        border-radius: 20px; border: 1px solid #ddd; padding: 10px 20px;
    }
    .form-control-rounded:focus, .form-select-rounded:focus {
        border-color: var(--color-verde-principal); box-shadow: 0 0 0 3px rgba(116, 198, 157, 0.2);
    }
    .form-label { font-weight: 600; font-size: 0.9rem; margin-bottom: 5px; color: var(--color-acento); }

    /* === BOTONES === */
    .btn-cta {
        background: linear-gradient(135deg, var(--color-verde-principal), var(--color-acento));
        color: white; padding: 10px 25px; border-radius: 50px;
        font-weight: 700; border: none; width: 100%;
        box-shadow: 0 10px 25px rgba(116, 198, 157, 0.4);
        transition: all 0.3s ease;
    }
    .btn-cta:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(116, 198, 157, 0.6);
        color: white;
    }

    /* === PESTAÑAS (PILLS) === */
    .nav-pills-custom .nav-link {
        color: var(--color-verde-oscuro);
        background: rgba(255,255,255,0.6);
        border: 1px solid rgba(116, 198, 157, 0.3);
        border-radius: 50px;
        padding: 10px 20px;
        margin-right: 10px; margin-bottom: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .nav-pills-custom .nav-link:hover {
        background: var(--color-verde-suave);
    }
    .nav-pills-custom .nav-link.active {
        background: linear-gradient(135deg, var(--color-verde-principal), var(--color-acento));
        color: white;
        border-color: transparent;
        box-shadow: 0 5px 15px rgba(116, 198, 157, 0.4);
    }

    /* === CONTACT ITEMS === */
    .contact-item {
        background-color: var(--color-fondo-crema);
        border-radius: 20px; padding: 15px; margin-bottom: 10px;
        border: 1px solid transparent; transition: all 0.2s ease;
    }
    .contact-item:hover { border-color: var(--color-verde-principal); }

    /* === BLOBS === */
    .blob { position: absolute; border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%; filter: blur(60px); z-index: -1; opacity: 0.6; }
    .blob-1 { top: -10%; left: -10%; width: 500px; height: 500px; background-color: var(--color-verde-suave); }
    .blob-2 { bottom: -10%; right: -10%; width: 400px; height: 400px; background-color: #95D5B2; }

</style>

<!-- Blobs de fondo -->
<div class="blob blob-1"></div>
<div class="blob blob-2"></div>

<div class="container pt-4 pb-5 position-relative" style="z-index: 5;">
    
    <!-- Botón de Regreso -->
    <div class="mb-4">
        <a href="{{ route('dashboard') }}" class="text-decoration-none fw-bold" style="color: var(--color-acento);">
            <i class="bi bi-arrow-left"></i> Volver al Panel
        </a>
    </div>

    <!-- Encabezado -->
    <div class="text-center mb-5">
        <h1 class="hero-title display-5 mb-2">
            Mi <span class="highlight-shape">Perfil</span>
        </h1>
        <p class="text-muted mx-auto" style="max-width: 600px;">
            Mantén tu información personal al día para facilitar los procesos de adopción.
        </p>
    </div>

    @include('partials.alerts')

    @if(Session::get('user_role') === 'User' && empty($user['address']))
    <div class="alert alert-warning border-0 rounded-4 shadow-sm mb-5 d-flex align-items-center" role="alert" style="background-color: #FFF3CD; color: #856404;">
        <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
        <div>
            <strong>¡Atención!</strong> Para poder solicitar una adopción, es necesario que completes tu dirección en la pestaña de Información Personal.
        </div>
    </div>
    @endif

    <div class="row g-4">
        
        {{-- COLUMNA IZQUIERDA: FOTO DE PERFIL --}}
        <div class="col-lg-4">
            <div class="feature-card text-center h-auto sticky-top" style="top: 20px; z-index: 10;">
                <div class="mb-4 position-relative d-inline-block">
                    @php
                        // Si la ruta es absoluta (http...), úsala tal cual. Si es relativa, concatena storage
                        $photoUrl = !empty($user['profile_photo_path']) 
                            ? (Str::startsWith($user['profile_photo_path'], 'http') ? $user['profile_photo_path'] : $apiUrl . '/storage/' . $user['profile_photo_path'])
                            : 'https://ui-avatars.com/api/?name='.urlencode($user['first_name'].'+'.$user['last_name']).'&background=74C69D&color=fff&size=200';
                    @endphp
                    
                    <img src="{{ $photoUrl }}" alt="Foto de perfil" class="rounded-circle shadow-lg object-fit-cover" style="width: 150px; height: 150px; border: 5px solid white;">
                    
                    <span class="position-absolute bottom-0 end-0 bg-success p-2 rounded-circle border border-white border-2"></span>
                </div>
                
                <h4 class="fw-bold mb-1" style="color: var(--color-verde-oscuro);">{{ $user['first_name'] }} {{ $user['last_name'] }}</h4>
                <p class="text-muted mb-4 small">{{ $user['email'] }}</p>
                
                <form action="{{ route('user.profile.photo.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label class="form-label small text-start w-100 ps-2">Cambiar foto</label>
                    <div class="input-group">
                        <input type="file" class="form-control form-control-rounded rounded-end-0" name="photo" required style="font-size: 0.8rem;">
                        <button class="btn btn-primary rounded-start-0 rounded-end-pill px-3" type="submit">
                            <i class="bi bi-upload"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- COLUMNA DERECHA: PESTAÑAS Y FORMULARIOS --}}
        <div class="col-lg-8">
            <div class="feature-card">
                
                <!-- Pestañas de Navegación -->
                <ul class="nav nav-pills nav-pills-custom mb-4 justify-content-center justify-content-lg-start" id="profileTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="info-tab" data-bs-toggle="pill" data-bs-target="#personal-info" type="button">
                            <i class="bi bi-person-lines-fill me-1"></i> Información Personal
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contacts-tab" data-bs-toggle="pill" data-bs-target="#emergency-contacts" type="button">
                            <i class="bi bi-heart-pulse me-1"></i> Emergencia
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="password-tab" data-bs-toggle="pill" data-bs-target="#password-change" type="button">
                            <i class="bi bi-shield-lock me-1"></i> Contraseña
                        </button>
                    </li>
                </ul>

                <div class="tab-content pt-2">
                    
                    {{-- PESTAÑA 1: INFORMACIÓN PERSONAL --}}
                    <div class="tab-pane fade show active" id="personal-info" role="tabpanel">
                        <form action="{{ route('user.profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="role" value="{{ $user['roles'][0]['name'] ?? 'User' }}">

                            <h5 class="fw-bold mb-4 pb-2 border-bottom" style="color: var(--color-verde-oscuro);">Datos Básicos</h5>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Primer Nombre</label>
                                    <input type="text" name="first_name" class="form-control form-control-rounded" value="{{ old('first_name', $user['first_name']) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Segundo Nombre</label>
                                    <input type="text" name="middle_name" class="form-control form-control-rounded" value="{{ old('middle_name', $user['middle_name']) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Primer Apellido</label>
                                    <input type="text" name="last_name" class="form-control form-control-rounded" value="{{ old('last_name', $user['last_name']) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Segundo Apellido</label>
                                    <input type="text" name="second_last_name" class="form-control form-control-rounded" value="{{ old('second_last_name', $user['second_last_name']) }}" required>
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control form-control-rounded bg-light" value="{{ old('email', $user['email']) }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Teléfono</label>
                                    <input type="text" name="phone" class="form-control form-control-rounded" value="{{ old('phone', $user['phone']) }}" required>
                                </div>
                            </div>

                            @if(Session::get('user_role') === 'User')
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label">Tipo Documento</label>
                                        <select name="document_type" class="form-select form-select-rounded">
                                            <option value="Cédula" {{ old('document_type', $user['document_type']) == 'Cédula' ? 'selected' : '' }}>Cédula</option>
                                            <option value="Pasaporte" {{ old('document_type', $user['document_type']) == 'Pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Número Documento</label>
                                        <input type="text" name="document_number" class="form-control form-control-rounded" value="{{ old('document_number', $user['document_number']) }}" required>
                                    </div>
                                </div>

                                <h5 class="fw-bold mb-4 pb-2 border-bottom mt-5" style="color: var(--color-verde-oscuro);">Dirección de Domicilio</h5>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">Calle Principal y Secundaria</label>
                                        <input type="text" name="address[street]" class="form-control form-control-rounded" value="{{ old('address.street', $user['address']['street'] ?? '') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Ciudad</label>
                                        <input type="text" name="address[city]" class="form-control form-control-rounded" value="{{ old('address.city', $user['address']['city'] ?? '') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Provincia</label>
                                        <input type="text" name="address[province]" class="form-control form-control-rounded" value="{{ old('address.province', $user['address']['province'] ?? '') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Código Postal</label>
                                        <input type="text" name="address[postal_code]" class="form-control form-control-rounded" value="{{ old('address.postal_code', $user['address']['postal_code'] ?? '') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">País</label>
                                        <input type="text" name="address[country]" class="form-control form-control-rounded" value="{{ old('address.country', $user['address']['country'] ?? '') }}">
                                    </div>
                                </div>
                            @endif

                            <div class="mt-4 pt-3 text-end">
                                <button type="submit" class="btn-cta w-auto">
                                    <i class="bi bi-save me-2"></i> Guardar Cambios
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- PESTAÑA 2: CONTACTOS DE EMERGENCIA --}}
                    <div class="tab-pane fade" id="emergency-contacts" role="tabpanel">
                        <div class="row">
                            {{-- Lista de Contactos --}}
                            <div class="col-md-7 mb-4 mb-md-0 border-end pe-md-4">
                                <h6 class="fw-bold mb-3" style="color: var(--color-verde-oscuro);">Mis Contactos Guardados</h6>
                                
                                <div class="d-flex flex-column gap-2">
                                    @forelse($contacts as $contact)
                                        <div class="contact-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong class="d-block text-dark">{{ $contact['contact_name'] }}</strong>
                                                <small class="text-muted">
                                                    {{ $contact['relationship'] }} • {{ $contact['contact_phone'] }}
                                                </small>
                                            </div>
                                            <form action="{{ route('user.contacts.destroy', $contact['id_emergency_contacts']) }}" method="POST" onsubmit="return confirm('¿Eliminar este contacto?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @empty
                                        <div class="text-center py-4 text-muted border rounded-4 bg-light">
                                            <i class="bi bi-journal-x fs-1 opacity-50"></i>
                                            <p class="mt-2 mb-0 small">No hay contactos registrados.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            {{-- Formulario para Añadir --}}
                            <div class="col-md-5 ps-md-4">
                                <h6 class="fw-bold mb-3" style="color: var(--color-acento);">Añadir Nuevo Contacto</h6>
                                <form action="{{ route('user.contacts.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label small">Nombre Completo</label>
                                        <input type="text" class="form-control form-control-rounded" name="contact_name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small">Teléfono</label>
                                        <input type="text" class="form-control form-control-rounded" name="contact_phone" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small">Relación</label>
                                        <input type="text" class="form-control form-control-rounded" name="relationship" placeholder="Ej: Madre" required>
                                    </div>
                                    <button type="submit" class="btn-cta btn-sm py-2">
                                        <i class="bi bi-plus-circle me-1"></i> Añadir
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- PESTAÑA 3: CAMBIAR CONTRASEÑA --}}
                    <div class="tab-pane fade" id="password-change" role="tabpanel">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <form action="{{ route('user.profile.password.update') }}" method="POST" class="p-3">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="mb-4">
                                        <label class="form-label">Contraseña Actual</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0 rounded-start-pill ps-3"><i class="bi bi-key"></i></span>
                                            <input type="password" name="current_password" class="form-control form-control-rounded border-start-0" required>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Nueva Contraseña</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0 rounded-start-pill ps-3"><i class="bi bi-lock"></i></span>
                                            <input type="password" name="password" class="form-control form-control-rounded border-start-0" required>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Confirmar Nueva Contraseña</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0 rounded-start-pill ps-3"><i class="bi bi-check2-circle"></i></span>
                                            <input type="password" name="password_confirmation" class="form-control form-control-rounded border-start-0" required>
                                        </div>
                                    </div>

                                    <div class="text-center mt-5">
                                        <button type="submit" class="btn-cta w-auto px-5">
                                            Actualizar Contraseña
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection