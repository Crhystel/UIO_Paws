@extends('layouts.app')

@section('title', 'Revisar Solicitud de Donación')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Revisar Solicitud de Donación #{{ $application['id_donation_application'] }}</h1>
    <div class="row">
        <div class="col-lg-8">
            {{-- Detalles del Donante --}}
            <div class="card mb-4">
                <div class="card-header">Información del Donante</div>
                <div class="card-body">
                    <h4>{{ $application['user']['first_name'] }} {{ $application['user']['last_name'] }}</h4>
                    <p><strong>Email:</strong> {{ $application['user']['email'] }}</p>
                </div>
            </div>

            {{-- Artículos Ofrecidos --}}
            <div class="card mb-4">
                <div class="card-header">Artículos Ofrecidos</div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($application['items'] as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $item['item_name'] }}
                                <span class="badge bg-primary rounded-pill">Cantidad: {{ $item['pivot']['quantity'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">Acciones</div>
                <div class="card-body">
                    <form action="{{ route('admin.applications.donation.updateStatus', $application['id_donation_application']) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="id_status" class="form-label"><strong>Cambiar Estado:</strong></label>
                            <select name="id_status" id="id_status" class="form-select" required>
                                @foreach($statuses as $status)
                                    <option value="{{ $status['id_status'] }}" {{ $status['id_status'] == $application['id_status'] ? 'selected' : '' }}>
                                        {{ $status['status_name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="admin_notes" class="form-label">Notas (visibles para el usuario)</label>
                            <textarea name="admin_notes" id="admin_notes" class="form-control" rows="4">{{ $application['admin_notes'] }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Actualizar Estado</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection