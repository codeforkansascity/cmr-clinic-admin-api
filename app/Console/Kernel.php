<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
  //      'App\Console\Commands\ConvertTextDatesCommand',
        'App\Console\Commands\MakeFirstUser',
        'App\Console\Commands\SetInitialPermissions',
        'App\Console\Commands\SetYesNoCommand',
        'App\Console\Commands\LoadStatutesFromScott',
        'App\Console\Commands\LoadCriminalHistory',
        'App\Console\Commands\EmailTestCommand',
        'App\Console\Commands\ConvertChargeStatuteToFK',
        'App\Console\Commands\ApiTest',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
