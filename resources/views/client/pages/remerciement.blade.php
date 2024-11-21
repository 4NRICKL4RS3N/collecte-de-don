@extends('client.layouts.app')

@section('titre', 'Merci!')

@section('content')
    <div class="container my-5">
        <div class="row text-center">
            <div class="col-sm-12 col-md-8 mx-auto align-self-center">
                <h1 class="grand-titre">Un <span>grand merci</span> pour votre contribution !</h1>
                <p class="my-4">Votre don nous aide à transformer des vies et à bâtir un meilleur avenir.</p>
                <x-client.button add-class="btn-primary" content="Explorer" lien="/projets"/>
            </div>
        </div>
    </div>
@endsection
