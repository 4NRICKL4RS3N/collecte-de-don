<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <title>Accueil</title>
</head>
<body>

    {{--  header  --}}
    <header>
        <x-header />
    </header>

    <main class="accueil">
        {{--  jumbotron  --}}
        <section class="jumbotron">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <h1 class="display-4"><span class="bold-text">Participez</span> à notre mission d'évangélisation</h1>
                        <a class="btn btn-primary btn-lg" href="#cta-link" role="button">Faites une différence aujourd'hui</a>
                    </div>
                </div>
            </div>
        </section>
    </main>


</body>
</html>
