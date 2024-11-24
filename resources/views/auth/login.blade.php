<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('images/vdfi_logo.ico.png') }}"/>
    @vite(['resources/sass/admin/app.scss'])
    <title>Login</title>
</head>
<body>
<div class="bg-body-tertiary min-vh-100 d-flex flex-row align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card-group d-block d-md-flex row">
                    <div class="card col-md-7 p-4 mb-0">
                        <div class="card-body">
                            <div class="container d-flex mb-4">
                                <img class="w-25 mx-auto" src="{{ asset('images/logo.png') }}">
                            </div>
                            <h1>Connexion</h1>
                            <p class="text-body-secondary">Connectez-vous avec votre compte admin</p>
                            <form method="post" action="{{ route('login') }}">
                                @csrf
                                @error('erreur')
                                    <span class="text-danger-emphasis">{{ $message }}</span>
                                @enderror
                                <div class="input-group mb-3"><span class="input-group-text">
                      <svg class="icon">
                        <use xlink:href="/svg/coreui/free.svg#cil-user"></use>
                      </svg></span>
                                    <input name="email" class="form-control" type="text" placeholder="Email">
                                </div>
                                <div class="input-group mb-4"><span class="input-group-text">
                      <svg class="icon">
                        <use xlink:href="/svg/coreui/free.svg#cil-lock-locked"></use>
                      </svg></span>
                                    <input name="password" class="form-control" type="password" placeholder="Mot de passe">
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <button class="btn btn-primary px-4" type="submit">Se connecter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
