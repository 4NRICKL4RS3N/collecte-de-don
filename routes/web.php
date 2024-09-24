<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PayPalController;

Route::get('/', function () {
    return redirect('/accueil');
});

Route::get('/accueil', function () {
    return view('accueil');
});

Route::get('/projets', function () {
    return view('projets');
});

