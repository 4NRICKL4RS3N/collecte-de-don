<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('images/vdfi_logo.ico.png') }}"/>
    <title>@yield('titre', 'admin')</title>
    @vite(['resources/sass/admin/app.scss'])
    @stack('styles')
    @stack('scripts_head')
</head>
<body>

<div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
    @include('admin.layouts.partials.sidebar')
</div>

<div class="wrapper d-flex flex-column min-vh-100">
    <header class="header header-sticky p-0 mb-4" style="background-color: #f3f4f7; border-bottom: 0px;">
        @include('admin.layouts.partials.header')
    </header>

    <div class="body flex-grow-1">
        <div class="container-lg px-4">
            @yield('content')
        </div>
    </div>

    <footer class="footer px-4">
        @include('admin.layouts.partials.footer')
    </footer>
</div>

@vite(['resources/js/admin-app.js'])
@stack('scripts')
</body>
</html>
