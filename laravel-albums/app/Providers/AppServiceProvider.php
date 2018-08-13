<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ArtistService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(ArtistService::class, function ($app) {
            return new ArtistService();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
