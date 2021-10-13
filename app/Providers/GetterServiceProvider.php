<?php

namespace App\Providers;

use App\Services\GetterService;
use Illuminate\Support\ServiceProvider;

class GetterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('GetterService', function ($app) {
            return new GetterService;
        });
    }
}
