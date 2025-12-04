@csrf
@if ($errors->any())
<div class="alert alert-danger rounded-3">
    <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
</div>
@endif

<div class="mb-4">
    <label for="species_name" class="form-label fw-bold small text-muted">NOMBRE DE LA ESPECIE</label>
    <input type="text" class="form-control form-control-lg rounded-pill" id="species_name" name="species_name" value="{{ old('species_name', $species['species_name'] ?? '') }}" required>
</div>

<div class="mt-4 border-top pt-4">
    <button type="submit" class="btn-cta">{{ $buttonText }}</button>
    <a href="{{ route('admin.species.index') }}" class="btn btn-secondary rounded-pill">Cancelar</a>
</div>