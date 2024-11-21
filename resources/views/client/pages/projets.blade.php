@extends('client.layouts.app')

@section('titre', 'Projets')

@section('content')
    <div class="container py-4 py-xl-5">
        <div class="row titre-container">
            <h1 class="grand-titre">Nos projets d'<span>évangélisation</span></h1>
        </div>
        <div class="row gy-4 row-cols-1 row-cols-md-2 row-cols-xl-3">
            {{--  project card  --}}
            @foreach($projets as $projet)
                <div data-id="{{ $projet->id }}" class="project-card col">
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
                            <a href="{{ route('client.projets.details', $projet->id) }}" class="project-link fw-bold">En savoir plus</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- "Contribuer" cursor --}}
        <div class="contribute-cursor" id="contributeCursor">
            <span>Contribuer</span>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        const contributeCursor = document.getElementById("contributeCursor");
        const projectCard = document.querySelectorAll(".project-card");

        let cursorX = 0, cursorY = 0;
        let delayedX = 0, delayedY = 0;

        // Update cursor position
        document.addEventListener("mousemove", (e) => {
            cursorX = e.pageX;
            cursorY = e.pageY-10;
        });

        function updateCursor() {
            delayedX += (cursorX - delayedX) * 0.1; // Interpolate to create delay
            delayedY += (cursorY - delayedY) * 0.1;

            contributeCursor.style.left = `${delayedX}px`;
            contributeCursor.style.top = `${delayedY-10}px`;

            requestAnimationFrame(updateCursor);
        }
        updateCursor();

        // Show/hide cursor on card hover
        projectCard.forEach((card) => {
            card.addEventListener("mouseenter", () => {
                contributeCursor.style.transform = "translate(-50%, -50%) scale(1)";
            });

            card.addEventListener("mouseleave", () => {
                contributeCursor.style.transform = "translate(-50%, -50%) scale(0)";
            });

            const projectId = card.getAttribute("data-id"); // Get the custom ID
            card.addEventListener("click", () => {
                window.location.href = `{{route('donate.afficher')}}?project=${projectId}`; // Replace with your desired URL
            });
        });

        // Restore default cursor when hovering the link
        document.querySelectorAll(".project-link").forEach((link) => {
            link.addEventListener("mouseenter", () => {
                contributeCursor.style.transform = "translate(-50%, -50%) scale(0)";
            });

            link.addEventListener("mouseleave", () => {
                contributeCursor.style.transform = "translate(-50%, -50%) scale(1)";
            });
        });
    </script>
@endpush
