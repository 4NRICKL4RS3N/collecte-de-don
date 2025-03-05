<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->usePublicPath('/home/cmjassoc/public_html');
        Blade::componentNamespace('App\\View\\Components\\Client', 'client');
        Carbon::setLocale('fr');
        if(config('app.env') === 'production') {
            \URL::forceScheme('https');
        }
    }
}
