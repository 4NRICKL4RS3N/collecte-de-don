@extends('client.layouts.app')

@section('titre', 'À propos')

@push('scripts_head')
    <script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>
@endpush

@section('content')
    <div class="container my-5">
        <div class="reveal-1 row text-center mb-sm-5 mb-2">
            <h1 class="grand-titre">À propos de <span>nous</span></h1>
        </div>
        <div class="reveal-2 row mb-5">
            <div class="col-md-6 px-1">
                <div class="a-propos-image-container rounded w-100 h-100" style="background-image: url('{{ asset("images/a-propos.jpg") }}');"></div>
            </div>
            <div class="col-md-6 px-5 py-md-5 py-3 contact-content">
                {!! $page_elements['apropos.content']->content !!}
                <x-client.button add-class="btn-primary" content="Nous contacter" lien="/contact"/>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const option = {
            distance: '50px',
            delay: 100,
            duration: 1000
        };
        ScrollReveal().reveal('.reveal-1', option);
        const option2 = {
            distance: '50px',
            delay: 200,
            duration: 1000
        };
        ScrollReveal().reveal('.reveal-2', option2);
    </script>
@endpush
