<?php

namespace App\Console;

use App\Console\Commands\ApiTest;
use App\Console\Commands\ConvertChargeStatuteToFK;
use App\Console\Commands\EmailTestCommand;
use App\Console\Commands\LoadCriminalHistory;
use App\Console\Commands\LoadStatutesFromScott;
use App\Console\Commands\MakeFirstUser;
use App\Console\Commands\SetInitialPermissions;
use App\Console\Commands\SetYesNoCommand;
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
        MakeFirstUser::class,
        SetInitialPermissions::class,
        SetYesNoCommand::class,
        LoadStatutesFromScott::class,
        LoadCriminalHistory::class,
        EmailTestCommand::class,
        ConvertChargeStatuteToFK::class,
        ApiTest::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
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
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
