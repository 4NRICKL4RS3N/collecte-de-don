<div class="container-fluid border-bottom px-4" style="justify-content: unset">
    <button class="header-toggler" type="button"
            onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()"
            style="margin-inline-start: -14px;">
        <svg class="icon icon-lg">
            <use xlink:href="/svg/coreui/free.svg#cil-menu"></use>
        </svg>
    </button>

    {{ Breadcrumbs::render() }}

    <form method="post" action="{{ route('logout') }}" class="position-absolute" style="right: 1rem">
        @csrf
        <button class="bg-transparent border-0" type="submit">
            <i class="fs-6 me-1 bi bi-box-arrow-left"></i>
            <span class="hover-underline">Se déconnecter</span>
        </button>
    </form>
</div>
