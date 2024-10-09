<div class="container-fluid border-bottom px-4" style="justify-content: unset">
    <button class="header-toggler" type="button"
            onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()"
            style="margin-inline-start: -14px;">
        <svg class="icon icon-lg">
            <use xlink:href="/svg/coreui/free.svg#cil-menu"></use>
        </svg>
    </button>
    {{ Breadcrumbs::render() }}
</div>
