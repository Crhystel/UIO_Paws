@extends('layouts.app')

@section('title', 'Qué Donar')

@section('content')
<div class="container mt-5">
    <div class="text-center mb-5">
        <h1 class="display-5">Ayúdanos a Cuidarlos</h1>
        <p class="lead text-muted">
            Tu generosidad es fundamental para mantener a nuestros animales sanos y felices.
            Aquí tienes una lista de los artículos que más necesitamos.
        </p>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        @forelse($items as $item)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title h4">{{ $item['item_name'] }}</h5>
                        <p class="card-text text-secondary">
                            {{ $item['description'] ?? 'Cada aporte, por pequeño que sea, hace una gran diferencia.' }}
                        </p>
                        <a href="{{ route('user.donations.create') }}" class="btn btn-outline-primary mt-auto">Quiero Donar</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <p class="h5">¡Por ahora lo tenemos todo cubierto!</p>
                    <p class="mb-0">Gracias por tu interés en ayudar. Vuelve a visitarnos pronto para ver nuevas necesidades.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection