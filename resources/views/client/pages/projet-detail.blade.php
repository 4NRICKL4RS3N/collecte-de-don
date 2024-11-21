@extends('client.layouts.app')

@section('titre', $projet->title)

@section('content')
    <div class="container py-4 py-xl-5">
        <div class="row titre-container">
            <h1 class="grand-titre">{{ $projet->title }}</h1>
        </div>

        <div class="row mb-4 projet-detail">
            <div class="col-lg-5 col-sm-12 offset-lg-1 offset-sm-0">

                {{-- Progress Bar --}}
                <p class="recolte"><span>{{ number_format($projet->donation_collected, 0, ',', ' ') }} Ar</span> récoltés sur <span>{{ number_format($projet->donation_target, 0, ',', ' ') }} Ar</span></p>
                <div class="progress mb-3">
                    <div
                        class="progress-bar"
                        role="progressbar"
                        style="width: {{ $projet->progress }}%;"
                        aria-valuenow="{{ $projet->progress }}"
                        aria-valuemin="0"
                        aria-valuemax="100">
                    </div>
                </div>

                <div class="mt-4 mb-4 info-list">
                    <i class="bi bi-geo-alt"></i><span>{{ $projet->location }}</span>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            @foreach($projet->getParagraphsDescription() as $paragraph)
                <div class="col-md-6">
                    <p>{!! $paragraph !!}</p>
                </div>
            @endforeach
        </div>

        <div class="row pswp-gallery pswp-gallery--single-column" id="project-gallery">
            @php
                $images = $projet->project_images;
                $widthHeight = $projet->getImagesWidthHeight();
            @endphp
            @for ($i = 0; $i < 3; $i++)
                <!-- Loop through 3 columns -->
                <div class="col-lg-4 col-md-12 mb-lg-0">
                    @for ($j = $i; $j < count($images); $j += 3)
                        <a href="{{ asset($images[$j]->url) }}"
                           data-pswp-width="{{ $widthHeight[$j]['width'] }}"
                           data-pswp-height="{{ $widthHeight[$j]['height'] }}"
                           data-pswp-type="{{ $images[$j]->type }}">
                            @if($images[$j]->type === 'image')
                                <img src="{{ asset($images[$j]->url) }}"
                                     class="w-100 shadow-1-strong rounded mb-4 gallery-image"
                                     alt="{{ $images[$j]->filename }}">
                            @else
                                <video class="w-100 shadow-1-strong rounded mb-4 gallery-image"
                                       src="{{ asset($images[$j]->url) }}" controls></video>
                            @endif
{{--                            <div class="hidden-caption-content">--}}
{{--                                {{ $images[$j]->filename }}--}}
{{--                            </div>--}}
                        </a>
                    @endfor
                </div>
            @endfor
        </div>
    </div>

    <section class="py-4 py-xl-5 project-cta">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-md-10 col-xl-8 text-center d-flex d-sm-flex d-md-flex justify-content-center align-items-center mx-auto justify-content-md-start align-items-md-center justify-content-xl-center">
                    <div>
                        <h1 class="fw-bold mb-3">Aidez-nous à concrétiser ce projet</h1>
                        <x-client.button add-class="btn-primary" content="Contribuer au projet" lien="/donate?project={{ $projet->id }}"/>
                        <x-client.button add-class="btn-outline-light mx-2" content="Explorer d'autres projets"
                                         lien="/projets"/>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    @vite(['resources/js/animateGradient.js'])
@endpush
