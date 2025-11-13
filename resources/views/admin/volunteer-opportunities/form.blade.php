@csrf
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
@endif

<div class="mb-3">
    <label for="title" class="form-label">Título del Puesto</label>
    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $opportunity['title'] ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="description" class="form-label">Descripción</label>
    <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description', $opportunity['description'] ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="requirements" class="form-label">Requisitos (Opcional)</label>
    <textarea class="form-control" id="requirements" name="requirements" rows="3">{{ old('requirements', $opportunity['requirements'] ?? '') }}</textarea>
</div>

<div class="form-check form-switch mb-3">
  <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $opportunity['is_active'] ?? true) ? 'checked' : '' }}>
  <label class="form-check-label" for="is_active">Oportunidad Activa (Visible para el público)</label>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-success">{{ $buttonText }}</button>
    <a href="{{ route('admin.volunteer-opportunities.index') }}" class="btn btn-secondary">Cancelar</a>
</div>