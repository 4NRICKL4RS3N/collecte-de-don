@extends('client.layouts.app')

@section('titre', 'À propos')

@section('content')
    <div class="container my-5">
        <div class="row text-center mb-sm-5 mb-2">
            <h1 class="grand-titre">À propos de nous</h1>
        </div>
        <div class="row mb-5">
            <div class="col-md-6 px-1">
                <div class="a-propos-image-container rounded w-100 h-100"></div>
            </div>
            <div class="col-md-6 px-5 py-md-5 py-3">
                <h2 class="fw-bolder">Nous accomplissons la volonté de Dieu</h2>
                <p>
                    Oporteatludus adipisci nullam tractatos eloquentiam alienum gloriatur. Prodefinitionem posse.
                    Ridenscursus ancillae signiferumque nibh solum propriae eum taciti. Suscipitreprimique lacus postea
                    fames ubique ius autem ad pharetra nonumy quot feugait theophrastus solum quaerendum graeco
                    venenatis cetero viderer.
                </p>
                <x-client.button add-class="btn-primary" content="Nous contacter" lien="/contact"/>
            </div>
        </div>
    </div>
@endsection
