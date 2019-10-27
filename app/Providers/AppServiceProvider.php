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
    }
}
