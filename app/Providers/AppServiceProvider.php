<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Ticket;
use App\Observers\OrderObserver;
use App\Observers\TicketObserver;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        if (\App::environment() === 'production') {
            $url->forceScheme('https');
        }
        Ticket::observe(TicketObserver::class);
        Order::observe(OrderObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
