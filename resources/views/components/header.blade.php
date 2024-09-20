<div class="container">
    <nav class="navbar navbar-expand-md">
        {{--logo vdfi--}}
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/vdfi_logo.png') }}" height="46" alt="logo vdfi">
        </a>

        {{--burger mobile view--}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{--menu items--}}
        <div class="collapse navbar-collapse justify-content-between" id="navbarMenu">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item mx-sm-2 mx-lg-4">
                    <a class="nav-link" href="#">Accueil</a>
                </li>
                <li class="nav-item mx-sm-2 mx-lg-4">
                    <a class="nav-link" href="#">À propos</a>
                </li>
                <li class="nav-item mx-sm-2 mx-lg-4">
                    <a class="nav-link" href="#">Projets</a>
                </li>
                <li class="nav-item mx-sm-2 mx-lg-4">
                    <a class="nav-link" href="#">Contact</a>
                </li>
            </ul>
            {{--CTA button--}}
            <a class="btn btn-primary my-2 my-lg-0" href="#">Faire un don</a>
        </div>

    </nav>
</div>
