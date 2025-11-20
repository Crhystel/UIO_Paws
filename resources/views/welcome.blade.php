@extends('layouts.app')

@section('title', 'Bienvenido a UIO Paws')

@section('content')
<div class="container py-5">

    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold mb-4">Dale un hogar a quien más lo necesita</h1>

        <img
            src="{{ asset('images/perrito1.jpg') }}"
            alt="Perrito listo para adopción"
            class="img-fluid rounded shadow-sm"
            style="max-width: 100%; height: auto;"
        >

        <div class="mt-4">
            <a href="#" class="btn btn-custom-blue btn-lg my-3">
                VER ANIMALES DISPONIBLES
            </a>

            <p class="text-muted mt-2">
                <strong>+100</strong> ANIMALES ADOPTADOS
            </p>
        </div>
    </div>

    <div class="row mt-5 justify-content-center">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="text-center">
                <img
                    src="{{ asset('images/golden retriever.jpg') }}"
                    alt="Dobby el Golden Retriever"
                    class="img-fluid rounded"
                    style="height: 200px; object-fit: cover; width: 100%;"
                >
                <h5 class="mt-2 mb-0 fw-bold">Dobby</h5>
                <p class="text-muted small">GOLDEN RETRIEVER</p>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="text-center">
                <img
                    src="{{ asset('images/gato bengala.jpg') }}"
                    alt="Kiri el Gato de Bengala"
                    class="img-fluid rounded"
                    style="height: 200px; object-fit: cover; width: 100%;"
                >
                <h5 class="mt-2 mb-0 fw-bold">Kiri</h5>
                <p class="text-muted small">GATO DE BENGALA</p>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="text-center">
                <img
                    src="{{ asset('images/perro mestizo.jpg') }}"
                    alt="Sam el Mestizo"
                    class="img-fluid rounded"
                    style="height: 200px; object-fit: cover; width: 100%;"
                >
                <h5 class="mt-2 mb-0 fw-bold">Sam</h5>
                <p class="text-muted small">MESTIZO</p>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="#" class="btn btn-custom-blue btn-lg">
            ENVIAR SOLICITUD
        </a>
    </div>

</div>
@endsection
