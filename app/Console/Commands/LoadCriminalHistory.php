<?php

namespace App\Console\Commands;

use App\Lib\AddApplicantFromCriminalHistory;
use App\Lib\GetCriminalHistoryFromSS;
use Illuminate\Console\Command;

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
        $this->file_name = 'Background-Check–AL.xls';

//        $this->path = '/Users/paulb/Projects/code4kc/cmr/cmr-clinic-admin-api/storage/app/applicant_histories';
//        $this->file_name = '1tddDwTHs2p73tzjatk0CderxpM1Xx4ej2VFL2FT.xls';
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo "start\n";

        $data = [];

        $ss = new GetCriminalHistoryFromSS($this->path, $this->file_name, $data);
        try {
            $data = $ss->processSpreadSheet();
            $r = new AddApplicantFromCriminalHistory($data);

            $r->addHistory();
        } catch (\Exception $e) {
            echo $e->getMessage()."\n";
        }

        echo "end\n";
    }
}
