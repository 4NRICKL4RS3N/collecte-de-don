<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\UploadMediaController;
use App\Http\Controllers\Auth\LoginController;
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
Route::post('/donate/failed/{id}', [DonationController::class, 'donationFailed'])->name('donate.failed');
Route::delete('/donate/delete/{id}', [DonationController::class, 'donationDestroy'])->name('donate.destroy');
Route::post('/stripe-webhook', [DonationController::class, 'handleWebhook']);


Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin');
        Route::get('/projets', [ProjectController::class, 'index'])->name('admin.projets');
        Route::get('/projets/{id}', [ProjectController::class, 'show'])->name('admin.projets.show');
        Route::post('/projets/{id}/process-upload', [ProjectController::class, 'processMedia'])->name('upload.process');
        Route::post('/projets', [ProjectController::class, 'store'])->name('admin.projets.store');
        Route::patch('/projets/update/{id}', [ProjectController::class, 'update'])->name('admin.projets.update');
        Route::delete('/projets/delete/{id}', [ProjectController::class, 'destroy'])->name('admin.projets.destroy');
        Route::delete('/projets/media/delete/{id}', [ProjectController::class, 'destroyMedia'])->name('admin.projets.media.destroy');
    });
});

Route::post('/upload-temp', [UploadMediaController::class, 'uploadTemporary'])->name('upload.temp');
Route::delete('/remove-temp', [UploadMediaController::class, 'removeTemporary'])->name('remove.temp');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
