@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Mi Perfil</h1>
    @if(Session::get('user_role') === 'User' && empty($user['address']))
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle"></i>
        <strong>¡Atención!</strong> Para poder solicitar una adopción, es necesario que completes tu dirección.
    </div>
    @endif
    @php
        $photoUrl = !empty($user['profile_photo_path'])
        ? $apiUrl . '/storage/' . $user['profile_photo_path']
        : 'https://via.placeholder.com/150';
    @endphp
            <img src="{{ $photoUrl }}"
                 alt="Foto de perfil" class="rounded-circle img-fluid" style="width: 150px;">

    @include('partials.alerts') 

    <div class="row">
        {{-- COLUMNA IZQUIERDA: FOTO Y PESTAÑAS --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{$user['profile_photo_url']}}"
                         alt="Foto de perfil" class="rounded-circle img-fluid" style="width: 150px;">
                    <h5 class="my-3">{{ $user['first_name'] }} {{ $user['last_name'] }}</h5>
                    <p class="text-muted mb-4">{{ $user['email'] }}</p>
                    
                    <form action="{{ route('user.profile.photo.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group">
                            <input type="file" class="form-control" name="photo" required>
                            <button class="btn btn-outline-primary" type="submit">Subir</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- COLUMNA DERECHA: FORMULARIOS --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#personal-info" type="button">Información Personal</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#password-change" type="button">Cambiar Contraseña</button>
                        </li>
                    </ul>
                    <div class="tab-content pt-3">
                        {{-- Pestaña de Información Personal --}}
                        <div class="tab-pane fade show active" id="personal-info" role="tabpanel">
                            <form action="{{ route('user.profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="role" value="{{ $user['roles'][0]['name'] ?? 'User' }}">

                                {{-- Nombres y Apellidos --}}
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Primer Nombre</label>
                                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $user['first_name']) }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Segundo Nombre</label>
                                        <input type="text" name="middle_name" class="form-control" value="{{ old('middle_name', $user['middle_name']) }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Primer Apellido</label>
                                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $user['last_name']) }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Segundo Apellido</label>
                                        <input type="text" name="second_last_name" class="form-control" value="{{ old('second_last_name', $user['second_last_name']) }}" required>
                                    </div>
                                </div>
                                {{-- Email y Teléfono --}}
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" value="{{ old('email', $user['email']) }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Teléfono</label>
                                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user['phone']) }}" required>
                                    </div>
                                </div>
                                {{-- Documento --}}
                                @if(Session::get('user_role') === 'User')
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tipo de Documento</label>
                                        <input type="text" name="document_type" class="form-control" value="{{ old('document_type', $user['document_type']) }}" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Número de Documento</label>
                                        <input type="text" name="document_number" class="form-control" value="{{ old('document_number', $user['document_number']) }}" required>
                                    </div>
                                </div>
                                <hr>
                                <h5>Dirección</h5>
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Calle</label>
                                        <input type="text" name="address[street]" class="form-control" value="{{ old('address.street', $user['address']['street'] ?? '') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Ciudad</label>
                                        <input type="text" name="address[city]" class="form-control" value="{{ old('address.city', $user['address']['city'] ?? '') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Provincia</label>
                                        <input type="text" name="address[province]" class="form-control" value="{{ old('address.province', $user['address']['province'] ?? '') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Código Postal</label>
                                        <input type="text" name="address[postal_code]" class="form-control" value="{{ old('address.postal_code', $user['address']['postal_code'] ?? '') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">País</label>
                                        <input type="text" name="address[country]" class="form-control" value="{{ old('address.country', $user['address']['country'] ?? '') }}">
                                    </div>
                                </div>
                                @endif
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </form>
                        </div>
                        {{-- Pestaña de Contraseña --}}
                        <div class="tab-pane fade" id="password-change" role="tabpanel">
                             <form action="{{ route('user.profile.password.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label class="form-label">Contraseña Actual</label>
                                    <input type="password" name="current_password" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nueva Contraseña</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Confirmar Nueva Contraseña</label>
                                    <input type="password" name="password_confirmation" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Actualizar Contraseña</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection