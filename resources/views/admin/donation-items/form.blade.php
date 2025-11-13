@csrf

@if ($errors->any())
    <div class="alert alert-danger">
        <strong class="h5">¡Error!</strong> Por favor, corrige los siguientes campos:
        <ul class="mt-2 mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="mb-3">
    <label for="item_name" class="form-label">Nombre del Artículo</label>
    <input type="text" class="form-control @error('item_name') is-invalid @enderror" id="item_name" name="item_name" value="{{ old('item_name', $item['item_name'] ?? '') }}" required>
    @error('item_name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div> 

<div class="mb-3">
    <label for="description" class="form-label">Descripción</label>
    <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $item['description'] ?? '') }}</textarea>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-success">{{ $buttonText }}</button>
    <a href="{{ route('admin.donation-items.index') }}" class="btn btn-secondary">Cancelar</a>
</div>