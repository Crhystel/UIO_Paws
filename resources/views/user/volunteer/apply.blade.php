@extends('layouts.app')
@section('title', 'Postulación a Voluntariado')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 overflow-hidden">
                <div class="card-header bg-primary text-white p-4">
                    <h3 class="mb-1"><i class="bi bi-person-heart me-2"></i>Únete a nuestro equipo</h3>
                    @if($opportunity)
                        <div class="alert alert-info">
                            Estás aplicando para: <strong>{{ $opportunity['title'] }}</strong>
                        </div>
                        <input type="hidden" name="id_volunteer_opportunity" value="{{ $opportunity['id_volunteer_opportunity'] }}">
                    @endif
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('user.volunteer.store') }}" method="POST">
                        @csrf
                        @if(isset($opportunity) && $opportunity)
                            <input type="hidden" name="id_volunteer_opportunity" value="{{ $opportunity['id_volunteer_opportunity'] }}">
                        @endif
                        <div class="mb-4">
                            <label class="form-label fw-bold">Disponibilidad Horaria</label>
                            <select name="availability" class="form-select" required>
                                <option value="">Selecciona...</option>
                                <option value="Fines de semana">Solo fines de semana</option>
                                <option value="Entre semana mañanas">Entre semana (Mañanas)</option>
                                <option value="Entre semana tardes">Entre semana (Tardes)</option>
                                <option value="Flexible">Horario Flexible</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Experiencia Previa con Animales</label>
                            <textarea name="experience" class="form-control" rows="3" placeholder="¿Has tenido mascotas o trabajado en refugios antes?" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Motivación Principal</label>
                            <div class="form-text mb-2">Cuéntanos por qué quieres ser parte de este cambio.</div>
                            <textarea name="motivation" class="form-control" rows="5" required minlength="50">{{ old('motivation') }}</textarea>
                            @error('motivation') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-check mb-4 bg-light p-3 rounded">
                            <input class="form-check-input" type="checkbox" name="terms_accepted" id="terms" required>
                            <label class="form-check-label small" for="terms">
                                Acepto comprometerme con las normas del refugio y tratar a los animales con respeto y amor.
                            </label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold">Enviar Solicitud</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection