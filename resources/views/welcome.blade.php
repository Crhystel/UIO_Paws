@extends('layouts.app')

@section('title', 'Bienvenido a UIO Paws')

@section('content')
<div class="p-5 mb-4 bg-light rounded-3 text-center">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Adopta un amigo, cambia una vida</h1>
        <p class="fs-4">En UIO Paws, conectamos corazones. Encuentra a tu compañero peludo perfecto o ayuda a quienes más lo necesitan.</p>
        <a href="{{ route('register.form') }}" class="btn btn-primary btn-lg">Únete a nuestra comunidad</a>
    </div>
</div>

<div class="row text-center">
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="card-title">🐶 Adoptar</h2>
                <p>Explora los perfiles de cientos de perros y gatos que esperan un hogar amoroso.</p>
                <p><a class="btn btn-secondary" href="#">Ver Animales &raquo;</a></p>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="card-title">❤️ Donar</h2>
                <p>Tu donación nos ayuda a cubrir gastos de alimentación, medicinas y cuidados.</p>
                <p><a class="btn btn-secondary" href="#">Hacer una Donación &raquo;</a></p>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="card-title">🙋‍♂️ Ser Voluntario</h2>
                <p>Regala tu tiempo y cariño. Necesitamos manos amigas para pasear, limpiar y jugar.</p>
                <p><a class="btn btn-secondary" href="#">Inscríbete &raquo;</a></p>
            </div>
        </div>
    </div>
</div>
@endsection