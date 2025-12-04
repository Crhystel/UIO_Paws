@csrf
@if ($errors->any())
    <div class="alert alert-danger rounded-3">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
@endif

<div class="mb-3">
    <label for="title" class="form-label fw-bold small text-muted">TÍTULO DEL PUESTO</label>
    <input type="text" class="form-control form-control-lg rounded-pill" id="title" name="title" value="{{ old('title', $opportunity['title'] ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="description" class="form-label fw-bold small text-muted">DESCRIPCIÓN</label>
    <textarea class="form-control form-control-lg rounded-3" id="description" name="description" rows="4" required>{{ old('description', $opportunity['description'] ?? '') }}</textarea>
</div>

<div class="mb-4">
    <label for="requirements" class="form-label fw-bold small text-muted">REQUISITOS (OPCIONAL)</label>
    <textarea class="form-control form-control-lg rounded-3" id="requirements" name="requirements" rows="3">{{ old('requirements', $opportunity['requirements'] ?? '') }}</textarea>
</div>

<div class="form-check form-switch mb-4 p-0 d-flex align-items-center">
  <input class="form-check-input ms-0 me-2" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', $opportunity['is_active'] ?? true) ? 'checked' : '' }} style="transform: scale(1.5);">
  <label class="form-check-label fw-bold" for="is_active">Oportunidad Activa (Visible para el público)</label>
</div>

<div class="mt-4 border-top pt-4">
    <button type="submit" class="btn-cta">{{ $buttonText }}</button>
    <a href="{{ route('admin.volunteer-opportunities.index') }}" class="btn btn-secondary rounded-pill">Cancelar</a>
</div>