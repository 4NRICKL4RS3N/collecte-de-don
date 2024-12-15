@extends('client.layouts.app')

@section('titre', 'Projets')

@push('scripts_head')
    <script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
@endpush

@section('content')
    <div class="container">
        <div class="reveal-1 row titre-container">
            <h1 class="grand-titre">Nos projets d'<span>évangélisation</span></h1>
        </div>

        <div class="reveal-2 d-flex justify-content-center mb-5">
            <div class="col-md-8">
                <div class="advanced-search-container">
                    <!-- Main Search Bar -->
                    <div class="input-group mb-3">
                        <input
                            type="text"
                            class="form-control project-search"
                            id="mainSearchInput"
                            placeholder="Search..."
                        />
                        <button
                            class="btn btn-outline-secondary filter-btn"
                            type="button"
                            id="toggleAdvancedSearch"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="filter-icon">
                                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                            </svg>
                        </button>
                        <button class="ms-2 btn btn-primary search-button">Rechercher</button>
                    </div>

                    <!-- Advanced Search Filters -->
                    <div class="advanced-filters" id="advancedFilters">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <select class="form-select" id="categorySelect">
                                    <option value="">Select Category</option>
                                    <option value="electronics">Electronics</option>
                                    <option value="clothing">Clothing</option>
                                    <option value="books">Books</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="minPrice"
                                        placeholder="Min Price"
                                    />
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="maxPrice"
                                        placeholder="Max Price"
                                    />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <input
                                    type="date"
                                    class="form-control"
                                    id="dateFrom"
                                    placeholder="From Date"
                                />
                            </div>
                            <div class="col-md-6">
                                <input
                                    type="date"
                                    class="form-control"
                                    id="dateTo"
                                    placeholder="To Date"
                                />
                            </div>
                            <div class="col-12 d-flex justify-content-between">
                                <button
                                    class="btn btn-secondary"
                                    id="clearFilters"
                                >
                                    Clear Filters
                                </button>
                                <button
                                    class="btn btn-primary"
                                    id="searchButton"
                                >
                                    Search
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="search-pill-container text-center mb-4">
            <!-- Le pill sera ajouté dynamiquement ici -->
        </div>

        <div class="reveal-3 loading-container row gy-4 row-cols-1 row-cols-md-2 row-cols-xl-3">
            <div class="project-card col">
                <div class="card rounded-4">
                    <h5 class="card-title placeholder-glow">
                        <span class="placeholder col-6"></span>
                    </h5>
                    <p class="card-text placeholder-glow">
                        <span class="placeholder col-7"></span>
                        <span class="placeholder col-4"></span>
                        <span class="placeholder col-4"></span>
                        <span class="placeholder col-6"></span>
                        <span class="placeholder col-8"></span>
                    </p>
                </div>
            </div>
            <div class="project-card col">
                <div class="card rounded-4">
                    <h5 class="card-title placeholder-glow">
                        <span class="placeholder col-6"></span>
                    </h5>
                    <p class="card-text placeholder-glow">
                        <span class="placeholder col-7"></span>
                        <span class="placeholder col-4"></span>
                        <span class="placeholder col-4"></span>
                        <span class="placeholder col-6"></span>
                        <span class="placeholder col-8"></span>
                    </p>
                </div>
            </div>
            <div class="project-card col">
                <div class="card rounded-4">
                    <h5 class="card-title placeholder-glow">
                        <span class="placeholder col-6"></span>
                    </h5>
                    <p class="card-text placeholder-glow">
                        <span class="placeholder col-7"></span>
                        <span class="placeholder col-4"></span>
                        <span class="placeholder col-4"></span>
                        <span class="placeholder col-6"></span>
                        <span class="placeholder col-8"></span>
                    </p>
                </div>
            </div>
        </div>

        <div class="projects-container row gy-4 row-cols-1 row-cols-md-2 row-cols-xl-3">
            {{--  project card  --}}
        </div>

        {{-- "Contribuer" cursor --}}
        <div class="contribute-cursor" id="contributeCursor">
            <span>Contribuer</span>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        //search
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.querySelector('.project-search');
            const searchButton = document.querySelector('.search-button');
            // const filterSelect = document.querySelector('.select-filtre');
            const projectContainer = document.querySelector('.projects-container');
            const searchPillContainer = document.querySelector('.search-pill-container');
            const loadingContainer = document.querySelector('.loading-container');
            let currentQuery = '';

            function showSearchPill(query) {
                // Créer un pill avec la croix pour réinitialiser la recherche
                const pill = document.createElement('div');
                pill.classList.add('d-inline-flex', 'align-items-center', 'search-pill');
                pill.innerHTML = `
                    ${query}
                    <button type="button" class="btn-close ms-2" aria-label="Close"></button>
                `;

                // Ajouter le pill dans le conteneur
                searchPillContainer.innerHTML = ''; // Réinitialiser le conteneur
                searchPillContainer.appendChild(pill);

                // Ajouter l'événement pour réinitialiser la recherche lorsqu'on clique sur la croix
                pill.querySelector('.btn-close').addEventListener('click', function () {
                    resetSearch(); // Réinitialiser la recherche
                });
            }

            function resetSearch() {
                searchInput.value = ''; // Réinitialiser la valeur de l'input
                currentQuery = ''; // Réinitialiser la requête
                fetchProjects(); // Recharger les projets sans recherche
                searchPillContainer.innerHTML = ''; // Supprimer le pill
                toggleLoading(false)
            }

            function toggleLoading(show) {
                if (show) {
                    loadingContainer.className = 'reveal-3 loading-container row gy-4 row-cols-1 row-cols-md-2 row-cols-xl-3'; // Afficher le spinner
                    projectContainer.classList.add("d-none");
                } else {
                    loadingContainer.className = 'reveal-3 loading-container row gy-4 row-cols-1 row-cols-md-2 row-cols-xl-3 d-none'; // Masquer le spinner
                    projectContainer.classList.remove("d-none");
                }
            }

            async function fetchProjects(query = '', filter = 'pertinence') {
                const response = await fetch(`/projets/search?query=${query}&filter=${filter}`);
                const projects = await response.json();
                updateProjects(projects);

                const maxWords = 10; // Set the maximum number of words to display
                const textElements = document.querySelectorAll('.description');
                const readMoreLinks = document.querySelectorAll('.project-link');
                textElements.forEach(function (textElement, i) {
                    const originalText = textElement.innerText;
                    const words = originalText.split(' ');

                    if (words.length > maxWords) {
                        textElement.innerText = words.slice(0, maxWords).join(' ') + '...';
                        readMoreLinks[i].style.display = 'inline';
                    }
                });

                toggleLoading(false);
            }

            function updateProjects(projects) {
                projectContainer.innerHTML = '';
                projects.forEach(project => {
                    const card = document.createElement('div');
                    card.className = 'project-card col';
                    card.setAttribute('data-id', project.id);

                    let link_projet = `/projets/${project.id}`

                    const objectivesHtml = project.objectives.map(objective => `
                        <div class="me-2 objective-pill badge rounded-pill text-dark">${objective}</div>
                    `).join('');

                    card.innerHTML = `
                    <div class="card rounded-4">
                            {{-- Title --}}
                        <div class="titre d-flex justify-content-between align-content-center">
                            <h2 class="project-title">${project.title}</h2>
                                </div>

                                {{-- Resume --}}
                        <span class="description">
                            ${project.description}
                            </span>
                            <a href="${link_projet}" class="mb-2 project-link fw-bold" style="display: none">En savoir plus</a>

                                {{-- Progress Bar --}}
                        <p class="text-progress"><span>${parseInt(project.donation_collected).toLocaleString()} Ar</span> récoltés</p>
                                <div class="progress mb-3">
                                    <div
                                        class="progress-bar"
                                        role="progressbar"
                                        style="width: ${project.progress}%;"
                                        aria-valuenow="${project.progress}"
                                        aria-valuemin="0"
                                        aria-valuemax="100">
                                    </div>
                                </div>

                                {{-- Objectives --}}
                        <div class="objectives">
                            ${objectivesHtml}
                        </div>

                                {{-- "En savoir plus" Link --}}
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="contribute-button d-none">
                                <span>Contribuer</span>
                            </div>
                        </div>
                    </div>
                    `;
                    projectContainer.appendChild(card);
                });
                const contributeCursor = document.getElementById("contributeCursor");
                const projectCard = document.querySelectorAll(".project-card");

                let cursorX = 0, cursorY = 0;
                let delayedX = 0, delayedY = 0;

                // Update cursor position
                document.addEventListener("mousemove", (e) => {
                    cursorX = e.pageX;
                    cursorY = e.pageY - 10;
                });

                function updateCursor() {
                    delayedX += (cursorX - delayedX) * 0.1; // Interpolate to create delay
                    delayedY += (cursorY - delayedY) * 0.1;

                    contributeCursor.style.left = `${delayedX}px`;
                    contributeCursor.style.top = `${delayedY - 10}px`;

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

                //description
                // const maxWords = 10; // Set the maximum number of words to display
                // const textElements = document.querySelectorAll('.description');
                // const readMoreLinks = document.querySelectorAll('.project-link');
                //
                // textElements.forEach(function (textElement, i) {
                //     const originalText = textElement.innerText;
                //     const words = originalText.split(' ');
                //
                //     if (words.length > maxWords) {
                //         textElement.innerText = words.slice(0, maxWords).join(' ') + '...';
                //         readMoreLinks[i].style.display = 'inline';
                //     }
                // });
                toggleLoading(false);
            }

            // searchInput.addEventListener("keypress", function (e) {
            //     if (e.key === "Enter") {
            //         toggleLoading(true);
            //         currentQuery = searchInput.value.trim();
            //         fetchProjects(searchInput.value, filterSelect.value); // Appeler la fonction quand l'utilisateur appuie sur Entrée
            //         showSearchPill(currentQuery);
            //     }
            // });
            // searchButton.addEventListener("click", function () {
            //     toggleLoading(true);
            //     currentQuery = searchInput.value.trim();
            //     fetchProjects(searchInput.value, filterSelect.value); // Appeler la fonction quand le bouton est cliqué
            //     showSearchPill(currentQuery);
            // });
            //
            // filterSelect.addEventListener('change', () => {
            //     toggleLoading(true);
            //     fetchProjects(searchInput.value, filterSelect.value);
            // });

            // Chargement initial
            fetchProjects();
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


        //advanced search pop
        (function() {
            document.addEventListener('DOMContentLoaded', function() {
                var toggleAdvancedSearch = document.getElementById('toggleAdvancedSearch');
                var advancedFilters = document.getElementById('advancedFilters');
                var clearFiltersBtn = document.getElementById('clearFilters');
                var searchButton = document.getElementById('searchButton');

                // Elements to track for active filters
                var filterInputs = [
                    'mainSearchInput',
                    'categorySelect',
                    'minPrice',
                    'maxPrice',
                    'dateFrom',
                    'dateTo'
                ];

                function checkActiveFilters() {
                    var hasActiveFilters = filterInputs.some(function(id) {
                        var element = document.getElementById(id);
                        return element.value.trim() !== '';
                    });

                    toggleAdvancedSearch.classList.toggle('active', hasActiveFilters);
                }

                // Toggle Advanced Search
                toggleAdvancedSearch.addEventListener('click', function() {
                    advancedFilters.classList.toggle('show');
                    checkActiveFilters();
                });

                // Clear Filters
                clearFiltersBtn.addEventListener('click', function() {
                    filterInputs.forEach(function(id) {
                        var element = document.getElementById(id);
                        element.value = '';
                    });
                    advancedFilters.classList.remove('show');
                    checkActiveFilters();
                });

                // Search Button
                searchButton.addEventListener('click', function() {
                    var searchData = {
                        keyword: document.getElementById('mainSearchInput').value,
                        category: document.getElementById('categorySelect').value,
                        minPrice: document.getElementById('minPrice').value,
                        maxPrice: document.getElementById('maxPrice').value,
                        dateFrom: document.getElementById('dateFrom').value,
                        dateTo: document.getElementById('dateTo').value
                    };

                    console.log('Search Data:', searchData);
                    // Implement your search logic here
                    alert('Search functionality to be implemented');
                });

                // Check filters on input change
                filterInputs.forEach(function(id) {
                    document.getElementById(id).addEventListener('input', checkActiveFilters);
                });
            });
        })();


    </script>
@endpush
