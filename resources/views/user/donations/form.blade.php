@extends('layouts.app')

@section('title', 'Ofrecer Donación')

@section('content')
<div class="container mt-5">
    <h1>Ofrecer Donación</h1>
    <p>Selecciona los artículos que te gustaría donar y especifica la cantidad. Tu generosidad nos ayuda a seguir adelante.</p>

    @if($errors->any())
    <div class="alert alert-danger">
        <p><strong>Por favor corrige los siguientes errores:</strong></p>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('user.donations.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header">
                <h5>Artículos que Necesitamos</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 5%;">Donar</th>
                                <th>Artículo</th>
                                <th>Descripción</th>
                                <th style="width: 15%;">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($itemsCatalog as $index => $item)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input item-checkbox" type="checkbox" name="items[{{ $index }}][id]" value="{{ $item['id_donation_item_catalog'] }}" id="item-check-{{ $index }}">
                                    </div>
                                </td>
                                <td><label for="item-check-{{ $index }}">{{ $item['item_name'] }}</label></td>
                                <td><small class="text-muted">{{ $item['description'] }}</small></td>
                                <td>
                                    <input type="number" name="items[{{ $index }}][quantity]" class="form-control item-quantity" min="1" value="1" disabled>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">No hay artículos en el catálogo en este momento.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success btn-lg mt-3 w-100">Enviar Ofrecimiento de Donación</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.item-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const quantityInput = this.closest('tr').querySelector('.item-quantity');
            quantityInput.disabled = !this.checked;
            if (!this.checked) {
                quantityInput.value = 1;
            }
        });
    });
});
</script>
@endpush