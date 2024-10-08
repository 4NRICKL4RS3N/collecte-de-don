@extends('client.layouts.app')

@section('titre', 'Accueil')

@section('content')
    {{--  jumbotron  --}}
    <div id="accueil">
        <section class="jumbotron">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <h1 class="display-4 grand-titre"><span class="bold-text">Participez</span> à notre mission
                            d'évangélisation</h1>
                        <x-client.button add-class="btn-primary" lien="/donate" content="Faites une différence aujourd'hui"/>
                    </div>
                </div>
            </div>
        </section>

        {{--  section 1  --}}
        <div class="container section-1 text-sm-start mb-5">
            <div class="row gy-2">
                <div class="col-md-6">
                    <h1 class="grand-titre">Notre projet d'évangélisation</h1>
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
                         src="{{ asset('images/section-1-image.jpg') }}"
                         style="border-radius: 10px;border-style: none;">
                </div>
            </div>
        </div>

        {{--  section 2  --}}
        <div class="container mb-2">
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
        <div class="container mb-5">
            <div class="row mb-4">
                <div class="col-sm-6 col-md-5 col-lg-4 offset-md-1 offset-lg-1">
                    <h1 class="petit-titre">Les impactes</h1>
                </div>
            </div>
            <div class="row gy-4 row-cols-1 row-cols-md-2 row-cols-xl-3">
                {{--  card  --}}
                <div class="col">
                    <div class="card card-impacte">
                        <div class="card-body p-4">
                            <h4 class="card-title">Title</h4>
                            <p class="card-text">Erat netus est hendrerit, nullam et quis ad cras porttitor iaculis.
                                Bibendum vulputate cras aenean.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-impacte">
                        <div class="card-body p-4">
                            <h4 class="card-title">Title</h4>
                            <p class="card-text">Erat netus est hendrerit, nullam et quis ad cras porttitor iaculis.
                                Bibendum vulputate cras aenean.</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-impacte">
                        <div class="card-body p-4">
                            <h4 class="card-title">Title</h4>
                            <p class="card-text">Erat netus est hendrerit, nullam et quis ad cras porttitor iaculis.
                                Bibendum vulputate cras aenean.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--  section 4  --}}
        <div class="container pt-2 mb-5">
            <div class="row">
                <div class="col">
                    <h1 class="grand-titre">Nos témoignages</h1>
                </div>
            </div>
            <div class="row slide-container">
                <section class="splide" aria-label="Splide Basic HTML Example">
                    <div class="splide__track">
                        <ul class="splide__list">
                            {{--  slide/témoignage  --}}
                            <li class="splide__slide">
                                <div class="card mb-3 slide-card " style="max-width: 540px;">
                                    <div class="row g-0 ">
                                        <div class="col-md-4 ">
                                            <img src="{{ asset('images/une femme.jpg') }}" class="img-fluid"
                                                 alt="...">
                                        </div>
                                        <div class="col-md-8" style="position: relative">
                                            <h5 class="quote">“</h5>
                                            <div class="card-body pt-4">
                                                <p class="card-text quote-text">Suscipianturverear proin legere
                                                    definitiones
                                                    gravida nunc aeque faucibus ignota percipit. Eirmodintellegat ea
                                                    cetero
                                                    labores singulis dolor definiebas porta nunc decore magnis pericula
                                                    dicunt. Electramdignissim eam.</p>
                                                <p class="card-text"><small class="text-muted">Rakoto Jean</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="splide__slide">
                                <div class="card mb-3 slide-card" style="max-width: 540px;">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <img src="{{ asset('images/une femme.jpg') }}"
                                                 class="img-fluid rounded-start"
                                                 alt="...">
                                        </div>
                                        <div class="col-md-8" style="position: relative">
                                            <h5 class="quote">“</h5>
                                            <div class="card-body pt-4">
                                                <p class="card-text quote-text">Suscipianturverear proin legere
                                                    definitiones
                                                    gravida nunc aeque faucibus ignota percipit. Eirmodintellegat ea
                                                    cetero
                                                    labores singulis dolor definiebas porta nunc decore magnis pericula
                                                    dicunt. Electramdignissim eam.</p>
                                                <p class="card-text"><small class="text-muted">Rakoto Jean</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="splide__slide">
                                <div class="card mb-3 slide-card" style="max-width: 540px;">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <img src="{{ asset('images/une femme.jpg') }}"
                                                 class="img-fluid rounded-start"
                                                 alt="...">
                                        </div>
                                        <div class="col-md-8" style="position: relative">
                                            <h5 class="quote">“</h5>
                                            <div class="card-body pt-4">
                                                <p class="card-text quote-text">Suscipianturverear proin legere
                                                    definitiones
                                                    gravida nunc aeque faucibus ignota percipit. Eirmodintellegat ea
                                                    cetero
                                                    labores singulis dolor definiebas porta nunc decore magnis pericula
                                                    dicunt. Electramdignissim eam.</p>
                                                <p class="card-text"><small class="text-muted">Rakoto Jean</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="splide__slide">
                                <div class="card mb-3 slide-card" style="max-width: 540px;">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <img src="{{ asset('images/une femme.jpg') }}"
                                                 class="img-fluid rounded-start"
                                                 alt="...">
                                        </div>
                                        <div class="col-md-8" style="position: relative">
                                            <h5 class="quote">“</h5>
                                            <div class="card-body pt-4">
                                                <p class="card-text quote-text">Suscipianturverear proin legere
                                                    definitiones
                                                    gravida nunc aeque faucibus ignota percipit. Eirmodintellegat ea
                                                    cetero
                                                    labores singulis dolor definiebas porta nunc decore magnis pericula
                                                    dicunt. Electramdignissim eam.</p>
                                                <p class="card-text"><small class="text-muted">Rakoto Jean</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="splide__slide">
                                <div class="card mb-3 slide-card" style="max-width: 540px;">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <img src="{{ asset('images/une femme.jpg') }}"
                                                 class="img-fluid rounded-start"
                                                 alt="...">
                                        </div>
                                        <div class="col-md-8" style="position: relative">
                                            <h5 class="quote">“</h5>
                                            <div class="card-body">
                                                <p class="card-text quote-text">Suscipianturverear proin legere
                                                    definitiones
                                                    gravida nunc aeque faucibus ignota percipit. Eirmodintellegat ea
                                                    cetero
                                                    labores singulis dolor definiebas porta nunc decore magnis pericula
                                                    dicunt. Electramdignissim eam.</p>
                                                <p class="card-text"><small class="text-muted">Rakoto Jean</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
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
                                    <x-button add-class="btn-light" lien="/donate" content="Faire un don maintenant"/>
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
    @vite('resources/js/slide.js')
@endpush
