@extends('client.layouts.app')

@section('titre', 'Projets')

@push('scripts_head')
    <script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>
@endpush

@section('content')
    <div class="container">
        <div class="reveal-1 row titre-container">
            <h1 class="grand-titre">Nos projets d'<span>évangélisation</span></h1>
        </div>

        <div class="reveal-2 row project-filtre align-items-center mb-5">
            <div class="col-md-6 text-md-start text-center">
                <input type="text" class="project-search form-control d-inline-block w-auto" placeholder="Rechercher" />
            </div>

            <div class="col-md-6 text-md-end text-center mt-4 mt-md-0">
                <p class="mb-0">
                    <span class="me-2">Filtrer par</span>
                    <select class="form-select select-filtre" name="filtre">
                        <option value="pertinence">Pertinence</option>
                        <option value="fonds_leves">Fonds levés</option>
                        <option value="les_plus_proches_du_but">Les plus proches du but</option>
                        <option value="les_plus_recents">Les plus récents</option>
                    </select>
                </p>
            </div>
        </div>

        <div class="reveal-3 row gy-4 row-cols-1 row-cols-md-2 row-cols-xl-3">
            {{--  project card  --}}
            @foreach($projets as $projet)
                <div data-id="{{ $projet->id }}" class="project-card col">
                    <div class="card rounded-4">
                        {{-- Title --}}
                        <div class="titre d-flex justify-content-between align-content-center">
                            <h2 class="project-title">{{ $projet->title }}</h2>
                        </div>

                        {{-- Resume --}}
                        <span class="description">
                            {!! $projet->description !!}
                        </span>
                        <a href="{{ route('client.projets.details', $projet->id) }}" class="mb-2 project-link fw-bold" style="display: none">En savoir plus</a>

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
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="contribute-button d-none">
                                <span>Contribuer</span>
                            </div>
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

        //scroll reveal
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
        const option3 = {
            distance: '50px',
            delay: 300,
            duration: 1000
        };
        ScrollReveal().reveal('.reveal-3', option3);

        //description
        const maxWords = 10; // Set the maximum number of words to display
        const textElement = document.querySelector('.description');
        const readMoreLink = document.querySelector('.project-link');

        const originalText = textElement.innerText;
        const words = originalText.split(' ');

        if (words.length > maxWords) {
            const truncatedText = words.slice(0, maxWords).join(' ') + '...';
            textElement.innerText = truncatedText;
            readMoreLink.style.display = 'inline';
        }
    </script>
@endpush
