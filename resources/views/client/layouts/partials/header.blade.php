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
        <div class="collapse navbar-collapse justify-content-between fullscreen-menu" id="navbarMenu">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item mx-sm-2 mx-lg-4 {{ Request::is('accueil') ? '' : 'menu-lien' }}">
                    <a class="nav-link {{ Request::is('accueil') ? 'bold-text' : '' }}" href="/accueil">Accueil</a>
                </li>
                <li class="nav-item mx-sm-2 mx-lg-4 {{ Request::is('a-propos') ? '' : 'menu-lien' }}">
                    <a class="nav-link {{ Request::is('a-propos') ? 'bold-text' : '' }}" href="/a-propos">À propos</a>
                </li>
                <li class="nav-item mx-sm-2 mx-lg-4 {{ Request::is('projets/*') ? '' : 'menu-lien' }}">
                    <a class="nav-link {{ Request::is('projets/*') ? 'bold-text' : '' }}" href="/projets">Projets</a>
                </li>
                <li class="nav-item mx-sm-2 mx-lg-4 {{ Request::is('contact') ? '' : 'menu-lien' }}">
                    <a class="nav-link {{ Request::is('contact') ? 'bold-text' : '' }}" href="/contact">Contact</a>
                </li>
            </ul>
            {{--CTA button--}}
            <x-client.button add-class="btn-primary" lien="/donate" content="{{ $page_elements['header.button']->content }}" />
        </div>
    </nav>
</div>
