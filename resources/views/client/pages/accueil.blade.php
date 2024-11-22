@extends('client.layouts.app')

@section('titre', 'Accueil')

@push('scripts_head')
    <script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>
@endpush

@section('content')
    {{--  jumbotron  --}}
    <div id="accueil">
        <section class="jumbotron" style="background-image: url('{{ asset($page_elements['accueil.hero.bgImage']->content) }}')">
            <div class="container-fluid">
                <div class="row reveal-0">
                    <div class="col-md-8 offset-md-2">
                        <h1 class="display-4 jumbotron-titre">{{ $page_elements['accueil.hero.titre']->content }}</h1>
                        <x-client.button add-class="btn-primary" lien="{{ route('client.projets') }}" content="{{ $page_elements['accueil.hero.button']->content }}"/>
                    </div>
                </div>
            </div>
        </section>

        {{--  section 1  --}}
        <div class="container section-1 text-sm-start mb-5">
            <div class="row gy-2">
                <div class="col-md-6">
                    <h1 class="grand-titre">Notre projet d'<span>évangélisation</span></h1>
                    <p class="mt-2 mt-xl-5">Lorem ipsum dolor sit amet consectetur adipiscing elit Ut et massa mi.
                        Aliquam
                        in hendrerit urna. Pellentesque sit amet sapien fringilla, mattis ligula consectetur, ultrices
                        mauris. Maecenas vitae mattis tellus. Nullam quis imperdiet augue. Vestibulum auctor ornare leo,
                        non
                        suscipit magna interdum eu. Curabitur pellentesque nibh nibh, at maximus ante.</p>
                </div>
                <div class="col-md-5 offset-0 offset-md-1 text-center text-sm-center text-md-end flex-fill"
                     style="transform: perspective(0px);">
                    <img class="img-fluid w-100 h-auto"
                         src="{{ asset($page_elements['accueil.section1.image']->content) }}"
                         style="border-radius: 10px;border-style: none;">
                </div>
            </div>
        </div>

        {{--  section 2  --}}
        <div class="section-2 container mb-2">
            <div class="row">
                <div class="col-sm-8 col-md-5 col-lg-4 offset-md-1 offset-lg-1">
                    <h1 class="petit-titre">Il est important parce que</h1>
                </div>
                <div class="col-md-5 offset-md-6">
                    <p>Lorem ipsum dolor sit amet consectetur adipiscing elit Ut et massa mi. Aliquam in hendrerit urna.
                        Pellentesque sit amet sapien fringilla, mattis ligula consectetur, ultrices mauris. Maecenas
                        vitae
                        mattis tellus. Nullam quis imperdiet augue. Vestibulum auctor ornare leo, non suscipit magna
                        interdum eu. Curabitur pellentesque nibh nibh, at maximus ante.</p>
                </div>
            </div>
        </div>

        {{--  section 3  --}}
        <div class="section-3 container mb-5">
            <div class="row mb-4">
                <div class="col-sm-6 col-md-5 col-lg-4 offset-md-1 offset-lg-1">
                    <h1 class="petit-titre">Les impactes</h1>
                </div>
            </div>
            <div class="row gy-4 row-cols-1 row-cols-md-2 row-cols-xl-3">
                {{--  card  --}}
                @foreach($impacts as $impact)
                    <div class="col d-flex">
                        <div class="card card-impacte h-100">
                            <div class="card-body p-4">
                                <h4 class="card-title">{{ $impact->title }}</h4>
                                <p class="card-text">{{ $impact->content }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{--  section 4  --}}
        <div class="section-4 container pt-2 mb-5">
            <div class="row">
                <div class="col">
                    <h1 class="grand-titre">Nos <span>témoignages</span></h1>
                </div>
            </div>
            <div class="row slide-container">
                <section class="splide" aria-label="Splide">
                    <div class="splide__track">
                        <ul class="splide__list">
                            {{--  slide/témoignage  --}}
                            @foreach($temoignages as $temoignage)
                                <li class="splide__slide">
                                    <div class="card mb-3 slide-card " style="max-width: 540px;">
                                        <div class="row g-0 ">
                                            <div class="col-md-4 ">
                                                <img src="{{ asset($temoignage->image_url) }}" class="img-fluid"
                                                     alt="...">
                                            </div>
                                            <div class="col-md-8" style="position: relative">
                                                <h5 class="quote">“</h5>
                                                <div class="card-body pt-4">
                                                    <p class="card-text quote-text">{{ $temoignage->statement }}</p>
                                                    <p class="card-text"><small class="text-muted">{{ $temoignage->testifier_name }}</small></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </section>
            </div>
        </div>

        {{--  section cta  --}}
        <div class="container mb-5">
            <section class="py-4 py-xl-5">
                <div class="container h-100">
                    <div class="section-cta text-white border rounded border-0 p-4 py-5">
                        <div class="row h-100">
                            <div
                                class="col-md-10 col-xl-8 text-center d-flex d-sm-flex d-md-flex justify-content-center align-items-center mx-auto justify-content-md-start align-items-md-center justify-content-xl-center">
                                <div>
                                    <h1 class="fw-medium text-white mb-3">
                                        Votre <span class="fw-bolder">générosité</span> fait la différence.
                                    </h1>
                                    <x-client.button add-class="btn-light" lien="/donate" content="Faire un don maintenant"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    @vite(['resources/js/animateGradient.js', 'resources/js/slide.js'])
    <script>
        const option = {
            distance: '50px',
            delay: 100,
            duration: 1000
        };
        ScrollReveal().reveal('.reveal-0', option);
        option.delay += 200;
        ScrollReveal().reveal('.section-1', option);
        ScrollReveal().reveal('.section-2', option);
        ScrollReveal().reveal('.section-3', option);
        ScrollReveal().reveal('.section-4', option);
    </script>
@endpush
