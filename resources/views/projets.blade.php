<!doctype html>
<html lang="en">
<head>
    <x-head titre="Projets"/>
</head>
<body>

{{--  header  --}}
<header>
    <x-header/>
</header>

<main>
    <div class="container py-4 py-xl-5">
        <div class="row">
            <h1 class="grand-titre">Nos projets d'évangélisation</h1>
        </div>
        <div class="row gy-4 row-cols-1 row-cols-md-2 row-cols-xl-3">
            <div class="project-card col">
                <div class="card rounded-4">
                    <div class="titre d-flex justify-content-between align-content-center">
                        <h2 class="project-title">Titre du projet</h2>
                        <div class="badge bg-primary rounded-pill status-badge px-3 py-1">en cours</div>
                    </div>
                    <p>Lorem ipsum dolor sit amet consectetur adipiscing elit Ut et massa mi. Aliquam in hendrerit urna. Pellentesque sit amet sapien fringilla, mattis ligula consectetur, ultrices mauris. Maecenas vitae mattis tellus.</p>

                    <div class="objectives">
                        <div class="objective-pill badge rounded-pill text-dark ">Objectif lorem ipsum dolor sit amet dolor sit amet dolor sit amet</div>
                        <div class="objective-pill badge rounded-pill text-dark ">Objectif lorem ipsum</div>
                        <div class="objective-pill badge rounded-pill text-dark ">Objectif lorem ipsum</div>
                    </div>
                    <div class="arrow-icon">
                        <img src="{{ asset('svg/arrow-narrow-right.svg') }}"/>
                    </div>
                </div>
            </div>
            <div class="project-card col">
                <div class="card">
                    <div class="status-badge">en cours</div>
                    <h2 class="project-title">Titre du projet</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipiscing elit Ut et massa mi. Aliquam in hendrerit urna. Pellentesque sit amet sapien fringilla, mattis ligula consectetur, ultrices mauris. Maecenas vitae mattis tellus.</p>

                    <div class="objectives">
                        <button class="objective-btn">Objectif lorem ipsum dolor sit amet</button>
                        <button class="objective-btn">Objectif lorem ipsum</button>
                        <button class="objective-btn">Objectif lorem ipsum</button>
                    </div>

                    <div class="arrow-icon">
                        <span>&#8594;</span>
                    </div>
                </div>
            </div>
            <div class="project-card col">
                <div class="card">
                    <div class="status-badge">en cours</div>
                    <h2 class="project-title">Titre du projet</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipiscing elit Ut et massa mi. Aliquam in hendrerit urna. Pellentesque sit amet sapien fringilla, mattis ligula consectetur, ultrices mauris. Maecenas vitae mattis tellus.</p>

                    <div class="objectives">
                        <button class="objective-btn">Objectif lorem ipsum dolor sit amet</button>
                        <button class="objective-btn">Objectif lorem ipsum</button>
                        <button class="objective-btn">Objectif lorem ipsum</button>
                    </div>

                    <div class="arrow-icon">
                        <span>&#8594;</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<footer>
    <x-footer/>
</footer>

</body>
</html>
