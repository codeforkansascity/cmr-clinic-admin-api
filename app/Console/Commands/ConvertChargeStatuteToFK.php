<?php

namespace App\Console\Commands;

use App\Lib\ChargeStatuteToFK;
use Illuminate\Console\Command;

class ConvertChargeStatuteToFK extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmr:convert-charge-statute-to-fk';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup charge, felony and set statute to FK';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $a = new ChargeStatuteToFK();
    }
}
