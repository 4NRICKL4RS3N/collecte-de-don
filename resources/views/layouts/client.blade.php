<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('images/vdfi_logo.ico.png') }}"/>
    <title>@yield('titre', 'VDFI')</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('styles')
    @stack('scripts_head')
</head>
<body>

    <header>
        @include('layouts.partials.header')
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        @include('layouts.partials.footer')
    </footer>

    @stack('scripts')
</body>
</html>
