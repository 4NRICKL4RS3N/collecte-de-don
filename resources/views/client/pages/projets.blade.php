@extends('client.layouts.app')

@section('titre', 'Projets')

@section('content')
    <div class="container py-4 py-xl-5">
        <div class="row titre-container">
            <h1 class="grand-titre">Nos projets d'évangélisation</h1>
        </div>
        <div class="row gy-4 row-cols-1 row-cols-md-2 row-cols-xl-3">
            {{--  project card  --}}
            @foreach($projets as $projet)
                <div class="project-card col">
                    <div class="card rounded-4">
                        {{-- Title --}}
                        <div class="titre d-flex justify-content-between align-content-center">
                            <h2 class="project-title">{{ $projet->title }}</h2>
                        </div>

                        {{-- Resume --}}
                        {!! $projet->description_resume !!}

                        {{-- Progress Bar --}}
                        <p class="text-progress"><span>{{ number_format($projet->donation_collected, 0, '.', ' ') }} Ar</span> récoltés</p>
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

                        {{-- Objectives --}}
                        <div class="objectives">
                            @foreach($projet->project_objectives as $objective)
                                <div class="me-2 objective-pill badge rounded-pill text-dark ">{{ $objective->objective }}</div>
                            @endforeach
                        </div>

                        {{-- "En savoir plus" Link --}}
                        <div class="text-end">
                            <a href="" class="fw-bold">En savoir plus</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
