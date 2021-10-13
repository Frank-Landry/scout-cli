<?php

namespace App\Providers;

use App\Services\BountyListService;
use Illuminate\Support\ServiceProvider;

class BountyListServiceProvider extends ServiceProvider
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
        $this->app->singleton('BountyListService', function ($app) {
            return new BountyListService;
        });
    }
}
