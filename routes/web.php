<?php

use App\Http\Controllers\admin\CMSController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\ImpactController;
use App\Http\Controllers\admin\TestimonyController;
use App\Http\Controllers\admin\UploadMediaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\client\DonationController;
use App\Http\Controllers\admin\ProjectController;
use App\Http\Controllers\client\PagesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(\route('client.accueil'));
});

Route::get('/accueil', [PagesController::class, 'accueil'])->name('client.accueil');

Route::get('/projets', [PagesController::class, 'projets'])->name('client.projets');
Route::get('/projets/search', [ProjectController::class, 'search'])->name('client.projets.search');

Route::get('/projets/{id}', [PagesController::class, 'projets_details'])->name('client.projets.details');

Route::get('/contact', [PagesController::class, 'contact'])->name('client.contact');

Route::get('/a-propos', [PagesController::class, 'a_propos'])->name('client.a-propos');

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
        Route::get('/dashboard-data', [DashboardController::class, 'dashboardData'])->name('admin.data');
        Route::prefix('projets')->group(function () {
            Route::get('/', [ProjectController::class, 'index'])->name('admin.projets');
            Route::post('/', [ProjectController::class, 'store'])->name('admin.projets.store');
            Route::get('/{id}', [ProjectController::class, 'show'])->name('admin.projets.show');
            Route::post('/{id}/process-upload', [ProjectController::class, 'processMedia'])->name('upload.process');
            Route::patch('/update/{id}', [ProjectController::class, 'update'])->name('admin.projets.update');
            Route::delete('/delete/{id}', [ProjectController::class, 'destroy'])->name('admin.projets.destroy');
            Route::delete('/media/delete/{id}', [ProjectController::class, 'destroyMedia'])->name('admin.projets.media.destroy');
        });
        Route::prefix('temoignages')->group(function () {
            Route::get('/', [TestimonyController::class, 'index'])->name('admin.temoignages');
            Route::post('/', [TestimonyController::class, 'store'])->name('admin.temoignages.store');
            Route::patch('/update/{id}', [TestimonyController::class, 'update'])->name('admin.temoignages.update');
            Route::delete('/delete/{id}', [TestimonyController::class, 'destroy'])->name('admin.temoignages.destroy');
        });
        Route::prefix('impacts')->group(function () {
            Route::get('/', [ImpactController::class, 'index'])->name('admin.impacts');
            Route::post('/', [ImpactController::class, 'store'])->name('admin.impacts.store');
            Route::patch('/update/{id}', [ImpactController::class, 'update'])->name('admin.impacts.update');
            Route::delete('/delete/{id}', [ImpactController::class, 'destroy'])->name('admin.impacts.destroy');
        });
        Route::prefix('cms')->group(function () {
            Route::post('/save', [CMSController::class, 'save'])->name('admin.cms.save');
            Route::get('/accueil', [CMSController::class, 'accueil'])->name('admin.cms.accueil');
            Route::get('/a-propos', [CMSController::class, 'a_propos'])->name('admin.cms.a-propos');
        });
    });
});

Route::post('/upload-temp', [UploadMediaController::class, 'uploadTemporary'])->name('upload.temp');
Route::delete('/remove-temp', [UploadMediaController::class, 'removeTemporary'])->name('remove.temp');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
