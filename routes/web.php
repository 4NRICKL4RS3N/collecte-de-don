<?php

use App\Http\Controllers\client\DonationController;
use App\Http\Controllers\admin\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/accueil');
});

Route::get('/accueil', function () {
    return view('client.pages.accueil');
});

Route::get('/projets', function () {
    return view('client.pages.projets');
});

Route::get('/contact', function () {
    return view('client.pages.contact');
});

Route::get('/a-propos', function () {
    return view('client.pages.a-propos');
});

Route::get('/projets/titre', function () {
    return view('client.pages.projet-detail');
});

Route::get('/donate', [DonationController::class, 'index'])->name('donate.afficher');
Route::post('/create-payment-intent', [DonationController::class, 'createPaymentIntent'])->name('createPaymentIntent');
Route::post('/confirm-payment', [DonationController::class, 'process'])->name('confirmPayment');
Route::get('/donate/remerciement', [DonationController::class, 'remerciement'])->name('donate.thank-you');
Route::post('/stripe-webhook', [DonationController::class, 'handleWebhook']);

Route::get('/admin/projets', [ProjectController::class, 'index'])->name('admin.projets');
Route::get('/admin/projets/{id}', [ProjectController::class, 'show'])->name('admin.projets.show');
Route::post('/admin/projets', [ProjectController::class, 'store'])->name('admin.projets.store');
Route::patch('/admin/projets/update/{id}', [ProjectController::class, 'update'])->name('admin.projets.update');
Route::delete('/admin/projets/delete/{id}', [ProjectController::class, 'destroy'])->name('admin.projets.destroy');
