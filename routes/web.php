<?php

use App\Http\Controllers\client\DonationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/accueil');
});

Route::get('/accueil', function () {
    return view('pages.client.accueil');
});

Route::get('/projets', function () {
    return view('pages.client.projets');
});

Route::get('/contact', function () {
    return view('pages.client.contact');
});

Route::get('/a-propos', function () {
    return view('pages.client.a-propos');
});

Route::get('/projets/titre', function () {
    return view('pages.client.projet-detail');
});

Route::get('/donate', [DonationController::class, 'index'])->name('donate.afficher');
Route::post('/create-payment-intent', [DonationController::class, 'createPaymentIntent'])->name('createPaymentIntent');
Route::post('/confirm-payment', [DonationController::class, 'process'])->name('confirmPayment');
Route::get('/donate/remerciement', [DonationController::class, 'remerciement'])->name('donate.thank-you');
Route::post('/stripe-webhook', [DonationController::class, 'handleWebhook']);
