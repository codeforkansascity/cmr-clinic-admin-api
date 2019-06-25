<?php

namespace App\Providers;

use Laravel\Passport\Passport;
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

        Passport::routes();

        // Give super-admin the ability to do anything
        //  From: https://github.com/spatie/laravel-permission/wiki/Global-%22Admin%22-role


        Gate::after(function ($user, $ability) {
            return true; //  $user->hasRole('super-admin'); // note this returns boolean
        });
    }
}
