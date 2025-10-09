@extends('layouts.app')

@section('title', 'Mi Panel')

@section('content')
    <h1>Bienvenido a tu panel, {{ Session::get('user_name') }}!</h1>
    <p>Desde aquí podrás gestionar tus adopciones, voluntariado y donaciones.</p>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
@endsection