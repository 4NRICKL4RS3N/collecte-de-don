<?php

use App\Http\Controllers\DonationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/accueil');
});

Route::get('/accueil', function () {
    return view('accueil');
});

Route::get('/projets', function () {
    return view('projets');
});

Route::get('/projets/titre', function () {
    return view('projet-detail');
});

Route::get('/donate', [DonationController::class, 'index'])->name('donate.afficher');
Route::post('/donate', [DonationController::class, 'process'])->name('donate.process');
