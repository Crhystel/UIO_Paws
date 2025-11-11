@csrf
@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
</div>
@endif
<div class="mb-3">
    <label for="species_name" class="form-label">Nombre de la Especie</label>
    <input type="text" class="form-control" id="species_name" name="species_name" value="{{ old('species_name', $species['species_name'] ?? '') }}" required>
</div>
<button type="submit" class="btn btn-success">{{ $buttonText }}</button>
<a href="{{ route('admin.species.index') }}" class="btn btn-secondary">Cancelar</a>