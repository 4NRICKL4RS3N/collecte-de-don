<div class="sidebar-header border-bottom">
    <div class="sidebar-brand">

        <img src="/images/logo.png" class="w-50 sidebar-brand-full">
    </div>
    <button class="btn-close d-lg-none" type="button" data-coreui-dismiss="offcanvas" data-coreui-theme="dark"
            aria-label="Close"
            onclick="coreui.Sidebar.getInstance(document.querySelector(&quot;#sidebar&quot;)).toggle()"></button>
</div>
<ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin') }}">
            <svg class="nav-icon">
                <use xlink:href="/svg/coreui/free.svg#cil-speedometer"></use>
            </svg>
            Tableau de bord
        </a>
    </li>
    <li class="nav-title">Entité</li>
    <li class="nav-group">
        <a class="nav-link" href="{{ route('admin.projets') }}">
            <svg class="nav-icon">
                <use xlink:href="/svg/coreui/free.svg#cil-puzzle"></use>
            </svg>
            Projets
        </a>
    </li>
    <li class="nav-group">
        <a class="nav-link" href="{{ route('admin.temoignages') }}">
            <svg class="nav-icon">
                <use xlink:href="/svg/coreui/free.svg#cil-puzzle"></use>
            </svg>
            Témoignages
        </a>
    </li>
    <li class="nav-group">
        <a class="nav-link" href="{{ route('admin.impacts') }}">
            <svg class="nav-icon">
                <use xlink:href="/svg/coreui/free.svg#cil-puzzle"></use>
            </svg>
            Impacts
        </a>
    </li>
    <li class="nav-title">Pages</li>
    <li class="nav-group">
        <a class="nav-link" href="{{ route('admin.cms.header-footer') }}">
            <svg class="nav-icon">
                <use xlink:href="/svg/coreui/free.svg#cil-file"></use>
            </svg>
            Header & Footer
        </a>
    </li>
    <li class="nav-group">
        <a class="nav-link" href="{{ route('admin.cms.accueil') }}">
            <svg class="nav-icon">
                <use xlink:href="/svg/coreui/free.svg#cil-file"></use>
            </svg>
            Accueil
        </a>
    </li>
    <li class="nav-group">
        <a class="nav-link" href="{{ route('admin.cms.a-propos') }}">
            <svg class="nav-icon">
                <use xlink:href="/svg/coreui/free.svg#cil-file"></use>
            </svg>
            À propos
        </a>
    </li>
    <li class="nav-group">
        <a class="nav-link" href="#">
            <svg class="nav-icon">
                <use xlink:href="/svg/coreui/free.svg#cil-file"></use>
            </svg>
            Projets
        </a>
    </li>
    <li class="nav-group">
        <a class="nav-link" href="#">
            <svg class="nav-icon">
                <use xlink:href="/svg/coreui/free.svg#cil-file"></use>
            </svg>
            Contact
        </a>
    </li>
    <li class="nav-group">
        <a class="nav-link" href="{{ route('admin.cms.donate') }}">
            <svg class="nav-icon">
                <use xlink:href="/svg/coreui/free.svg#cil-file"></use>
            </svg>
            Faire un don
        </a>
    </li>
    <li class="nav-group">
        <a class="nav-link" href="#">
            <svg class="nav-icon">
                <use xlink:href="/svg/coreui/free.svg#cil-file"></use>
            </svg>
            Remerciement
        </a>
    </li>
</ul>
<div class="sidebar-footer border-top d-none d-md-flex">
</div>
