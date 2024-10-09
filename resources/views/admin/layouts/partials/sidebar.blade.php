<div class="sidebar-header border-bottom">
    <div class="sidebar-brand">

        <img src="/images/vdfi_logo.png" class="w-25 sidebar-brand-full">
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
            Dashboard
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
    <li class="nav-title">Pages</li>
    <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
                <use xlink:href="/svg/coreui/free.svg#cil-puzzle"></use>
            </svg>
            Base</a>
        <ul class="nav-group-items compact">
            <li class="nav-item">
                <a class="nav-link" href="base/accordion.html">
                    <span class="nav-icon"><span class="nav-icon-bullet"></span></span>
                    Accordion
                </a>
            </li>
        </ul>
    </li>
</ul>
<div class="sidebar-footer border-top d-none d-md-flex">
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
