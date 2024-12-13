@extends('client.layouts.app')

@section('titre', 'Merci!')

@push('scripts_head')
    <script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>
@endpush

@section('content')
    <div class="reveal-1 container my-5">
        <div class="row text-center">
            <div class="col-sm-12 col-md-8 mx-auto align-self-center">
                <h1 class="grand-titre">Un <span>grand merci</span> pour votre contribution !</h1>
                <p class="my-4">Votre don nous aide à transformer des vies et à bâtir un meilleur avenir.</p>
                <x-client.button add-class="btn-primary" content="Explorer" lien="/projets"/>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const option = {
            scale: 0.85,
            delay: 100,
            duration: 2000
        };
        ScrollReveal().reveal('.reveal-1', option);
    </script>
@endpush
