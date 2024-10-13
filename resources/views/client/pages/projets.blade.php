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
                <a href="{{ route('client.projets.details', $projet->id) }}" style="text-decoration: none;">
                    <div class="project-card col">
                        <div class="card rounded-4">
                            <div class="titre d-flex justify-content-between align-content-center">
                                <h2 class="project-title">{{ $projet->title }}</h2>
                                <div class="badge rounded-pill status-badge px-3 py-1">{{ $projet->getStatus() }}</div>
                            </div>
                            <p>{{ $projet->description }}</p>

                            <div class="objectives">
                                @foreach($projet->project_objectives as $objective)
                                    <div class="ms-3 objective-pill badge rounded-pill text-dark ">{{ $objective->objective }}</div>
                                @endforeach
                            </div>
                            <div class="badge-container">
                                <div class="cta-badge">Soutenir</div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
