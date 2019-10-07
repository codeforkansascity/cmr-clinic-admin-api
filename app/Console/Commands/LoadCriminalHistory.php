<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Lib\GetCriminalHistoryFromSS;

class LoadCriminalHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmr:load-criminal-history';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load criminal history from spread sheet';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->path = '/Users/paulb/Projects/code4kc/cmr/cmr-clinic-admin-api/data';
        $this->file_name = 'Background-Check-DK.xls';
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        print "start\n";

        $data = [];

        $ss = new GetCriminalHistoryFromSS($this->path, $this->file_name, $data);
        try {
            $data = $ss->processSpreadSheet();
        } catch (\Exception $e) {
            print $e->getMessage() . "\n";

        }



        print "end\n";


    }
}
