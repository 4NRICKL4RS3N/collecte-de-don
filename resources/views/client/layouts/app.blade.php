<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.ico.png') }}"/>
    <title>@yield('titre', 'CMJ')</title>
    @vite(['resources/sass/client/app.scss', 'resources/js/app.js'])
    @stack('styles')
    @stack('scripts_head')
</head>
<body>

<header style="margin-bottom: 6rem">
    <x-client.header/>
</header>

<main>
    @yield('content')
</main>

<footer style="margin-top: 6rem">
    <x-client.footer/>
</footer>

@stack('scripts')

</body>
</html>
