<?php

namespace App\Providers;

use App\Applicant;
use App\Charge;
use App\Client;
use App\Conviction;
use App\Observers\ChargeObserver;
use App\Observers\StatuteObserver;
use App\Statute;
use App\Observers\ApplicantObserver;
use App\Observers\ConvictionObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
	// This should resolve the error Specified key was too long error
        //   from https://laravel-news.com/laravel-5-4-key-too-long-error
        Schema::defaultStringLength(191);

        Charge::observe(ChargeObserver::class);
        Statute::observe(StatuteObserver::class);
        Applicant::observe(ApplicantObserver::class);
        Conviction::observe(ConvictionObserver::class);

        /**
         * Validate that there is only a value in one and not the other.
         *
         *
         * Can be used like
         *
         *      'statute_id' => 'nullable|numeric|empty_with:imported_statute',
         *      'imported_statute' => 'nullable|string|max:255|empty_with:statute_id',

         */
        Validator::extend(
            'empty_with',
            function ($attribute, $value, $parameters)
            {
                if (empty($value) && empty(request($parameters[0]))) return false;
                if (!empty($value) && !empty(request($parameters[0]))) return false;
                return true;
            }
        );
    }
}
