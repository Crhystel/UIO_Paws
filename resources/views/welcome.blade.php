@extends('layouts.app')

@section('title', 'Bienvenido a UIO Paws')

@section('content')
    <div class="text-center p-5 bg-white rounded-3">
        <h1 class="display-4">¡Encuentra a tu nuevo mejor amigo!</h1>
        <p class="lead">Explora los perfiles de cientos de animales que esperan un hogar lleno de amor.</p>
        <hr class="my-4">
        <p>Tu apoyo puede cambiar una vida. Adopta, hazte voluntario o dona.</p>
        <a class="btn btn-primary btn-lg" href="{{ route('public.animals.index') }}" role="button">Ver Animales para Adoptar</a>
    </div>
@endsection