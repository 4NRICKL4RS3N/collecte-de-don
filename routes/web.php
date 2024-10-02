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

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/a-propos', function () {
    return view('a-propos');
});

Route::get('/projets/titre', function () {
    return view('projet-detail');
});

Route::get('/donate', [DonationController::class, 'index'])->name('donate.afficher');
Route::post('/create-payment-intent', [DonationController::class, 'createPaymentIntent'])->name('createPaymentIntent');
Route::post('/confirm-payment', [DonationController::class, 'process'])->name('confirmPayment');
Route::get('/donate/thank-you', [DonationController::class, 'thankYou'])->name('donate.thank-you');
Route::post('/stripe-webhook', [DonationController::class, 'handleWebhook']);
