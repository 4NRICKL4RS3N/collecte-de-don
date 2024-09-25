<!doctype html>
<html lang="en">
<head>
    <x-head titre="Titre Projet"/>
</head>
<body>

<header>
    <x-header/>
</header>

<main>
    <div class="container py-4 py-xl-5">
        <div class="row titre-container">
            <h1 class="grand-titre">Titre du projet</h1>
        </div>

        <div class="row mb-4">
            <div class="col offset-md-1 offset-sm-0">
                <ul class="info-list">
                    <li><i class="bi bi-geo-alt"></i><span>Antananarivo Madagascar</span></li>
                    <li><i class="bi bi-cash"></i>Objectif: <span>8000$</span></li>
                    <li><i class="bi bi-bank"></i>Récoltés: <span>2000$</span></li>
                </ul>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut et massa mi. Aliquam in hendrerit urna. Pellentesque sit amet sapien fringilla, mattis ligula consectetur, ultrices mauris. Maecenas vitae mattis tellus. Nullam quis imperdiet augue. Vestibulum auctor ornare leo, non suscipit magna interdum eu. Curabitur pellentesque nibh nibh, at maximus ante fermentum sit amet. Pellentesque commodo lacus at sodales sodales. Quisque sagittis orci ut diam condimentum, vel euismod erat placerat.</p>
            </div>
            <div class="col-md-6">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut et massa mi. Aliquam in hendrerit urna. Pellentesque sit amet sapien fringilla, mattis ligula consectetur, ultrices mauris. Maecenas vitae mattis tellus. Nullam quis imperdiet augue.</p>
            </div>
            <div class="col-md-6">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut et massa mi. Aliquam in hendrerit urna. Pellentesque sit amet sapien fringilla, mattis ligula consectetur, ultrices mauris. Maecenas vitae mattis tellus. Nullam quis imperdiet augue. Vestibulum auctor ornare leo, non suscipit magna interdum eu.</p>
            </div>
        </div>

        <div class="row pswp-gallery pswp-gallery--single-column" id="project-gallery">
            <div class="col-lg-4 col-md-12 mb-lg-0">
                <a href="{{ asset('images/jumbotron-bg.jpg') }}"
                   data-pswp-width="2048"
                   data-pswp-height="2048"
                   target="_blank">
                    <img
                        src="{{ asset('images/jumbotron-bg.jpg') }}"
                        class="w-100 shadow-1-strong rounded mb-4 gallery-image"
                        alt="Boat on Calm Water"
                    />
                </a>

                <a href="{{ asset('images/section-1-image.jpg') }}"
                   data-pswp-width="2048"
                   data-pswp-height="2048"
                   target="_blank">
                    <img
                        src="{{ asset('images/section-1-image.jpg') }}"
                        class="w-100 shadow-1-strong rounded mb-4 gallery-image"
                        alt="Wintry Mountain Landscape"
                    />
                </a>
            </div>

            <div class="col-lg-4 mb-lg-0">
                <a href="{{ asset('images/section-1-image.jpg') }}"
                   data-pswp-width="2048"
                   data-pswp-height="2048"
                   target="_blank">
                    <img
                        src="{{ asset('images/section-1-image.jpg') }}"
                        class="w-100 shadow-1-strong rounded mb-4 gallery-image"
                        alt="Mountains in the Clouds"
                    />
                </a>

                <a href="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/Nature/4-col/img%20(73).webp"
                   data-pswp-width="2048"
                   data-pswp-height="2048"
                   target="_blank">
                    <img
                        src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/Nature/4-col/img%20(73).webp"
                        class="w-100 shadow-1-strong rounded mb-4 gallery-image"
                        alt="Boat on Calm Water"
                    />
                </a>
            </div>

            <div class="col-lg-4 mb-lg-0">
                <a href="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/Nature/4-col/img%20(18).webp"
                   data-pswp-width="2048"
                   data-pswp-height="2048"
                   target="_blank">
                    <img
                        src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/Nature/4-col/img%20(18).webp"
                        class="w-100 shadow-1-strong rounded mb-4 gallery-image"
                        alt="Waves at Sea"
                    />
                </a>

                <a href="https://mdbcdn.b-cdn.net/img/Photos/Vertical/mountain3.webp"
                   data-pswp-width="2048"
                   data-pswp-height="2048"
                   target="_blank">
                    <img
                        src="https://mdbcdn.b-cdn.net/img/Photos/Vertical/mountain3.webp"
                        class="w-100 shadow-1-strong rounded mb-4 gallery-image"
                        alt="Yosemite National Park"
                    />
                </a>
            </div>
        </div>
    </div>

    <section class="py-4 py-xl-5 project-cta">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-md-10 col-xl-8 text-center d-flex d-sm-flex d-md-flex justify-content-center align-items-center mx-auto justify-content-md-start align-items-md-center justify-content-xl-center">
                    <div>
                        <h1 class="fw-bold mb-3">Aidez nous à concrétiser ce projet</h1>
                        <x-button add-class="btn-primary" content="Contribuer au projet" lien="#"  />
                        <x-button add-class="btn-outline-light mx-2" content="Explorer d'autres projets" lien="#"  />
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<footer>
    <x-footer/>
</footer>

</body>
</html>
