<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
        Gate::define('pay-order', function ($user,$order) {
            return $user->id == $order->user_id;
        });
        Gate::define('get-order', function ($user,$order) {

            return $user->id == $order->user_id || $user->isAdmin() || ($order->tickets()->count() > 0 && $user->id == $order->tickets()->first()->showtime->show->admin_id) ;
        });
        Gate::define('edit-order', function ($user,$order) {

            return $user->isAdmin() || ($order->tickets()->count() > 0 && $user->id == $order->tickets()->first()->showtime->show->admin_id) ;
        });

    }
}
