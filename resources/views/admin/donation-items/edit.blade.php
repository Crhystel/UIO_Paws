@extends('layouts.app')

@section('title', 'Editar Artículo')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header"><h1 class="h3 mb-0">Editar Artículo: {{ $item['item_name'] }}</h1></div>
        <div class="card-body">
            <form action="{{ route('admin.donation-items.update', $item['id_donation_item_catalog']) }}" method="POST">
                @method('PUT')
                @include('admin.donation-items.form', ['buttonText' => 'Actualizar Artículo'])
            </form>
        </div>
    </div>
</div>
@endsection