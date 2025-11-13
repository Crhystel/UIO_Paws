@extends('layouts.app')
@section('title', 'Sé un Voluntario')
@section('content')
<div class="container mt-5">
    <div class="text-center mb-5">
        <h1 class="display-5">¡Tu Ayuda Marca la Diferencia!</h1>
        <p class="lead text-muted">
            Ser voluntario es una de las formas más gratificantes de ayudar.
            Mira las áreas en las que necesitamos tu talento y tu pasión.
        </p>
    </div>
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div class="row g-4">
        @forelse($opportunities as $opportunity)
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title">{{ $opportunity['title'] }}</h3>
                        <p class="card-text">{{ $opportunity['description'] }}</p>
                        @if($opportunity['requirements'])
                            <h5 class="mt-4">Requisitos:</h5>
                            <p class="card-text text-secondary">{{ $opportunity['requirements'] }}</p>
                        @endif
                        <a href="{{ route('register.form') }}" class="btn btn-primary mt-3">¡Quiero Postularme!</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <p class="h5">¡Gracias por tu interés!</p>
                    <p class="mb-0">Por el momento no tenemos nuevas oportunidades de voluntariado, ¡pero vuelve a revisar pronto!</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection