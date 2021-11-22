<?php

namespace App\Console\Commands;

use App\Lib\AddApplicantFromCriminalHistory;
use App\Lib\GetCriminalHistoryFromSS;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class LoadSs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmr:load-ss';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test loading spreadsheet';



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
     * @return int
     */
    public function handle()
    {

        DB::beginTransaction();

        $this->path = '/Users/paulb/Projects/code4kc/cmr/current-cmr/data';
        $this->file_name = 'horizontal.xls';
        $this->file_name = 'cmr-test-Betty-Bednar.xls';

        $this->path = '/Users/paulb/Downloads';
        $this->file_name = 'cindy_abernathy.xls';

        $data = [];

        $ss = new GetCriminalHistoryFromSS($this->path, $this->file_name, $data);

        $data = $ss->processSpreadSheet();
print "Print data:\n";
        print_r($data);

//            $r = new AddApplicantFromCriminalHistory($data);
//
//            $r->addHistory();
//
//            print_r($r);


        echo "end\n";

        return 0;
    }
}
