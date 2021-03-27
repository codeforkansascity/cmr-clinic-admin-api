<?php

namespace App\Console\Commands;

use App\Charge;
use App\Conviction;
use Illuminate\Console\Command;

class FixSource extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-source';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $warnings = [];

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

        $convictons = Conviction::with('sources')
            ->select('id','source')
            ->where('source','<>','')
      //      ->where('applicant_id', 88)
            ->get();
//        print_r($convictons->toArray());

        foreach ($convictons AS $conviction) {
            if ($conviction->sources->count()) {
                print "Skipping " . $conviction->id . "\n";
            } else {
                $this->addSources($conviction, $conviction->source);
            }

        }

        print_r($this->warnings);

        return 0;
    }

    private function addSources(&$conviction, $sources)
    {
        $source_ids = [];

        $sources = explode(',', $sources);

        foreach ($sources as $source) {
            $source = trim($source);

            if ($source = 'MSPD') {
                $source = 'MSHP';
            }

            $rec = \App\DataSource::select('id')->where('name', $source)->first();

            if (! empty($rec)) {
                $source_ids[] = $rec->id;
            } else {
                $this->warnings[] = "Case source $source was not found";
            }
        }

        if (! empty($source_ids)) {
            $conviction->sources()->sync($source_ids);
        }
    }
}
