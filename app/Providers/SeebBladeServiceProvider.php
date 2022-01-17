<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SeebBladeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('SeebBlade', function () {
            return new \App\Classes\Seeb\SeebBladeHelper();
        });
    }
}
