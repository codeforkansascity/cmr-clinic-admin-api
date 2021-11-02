<?php

namespace App\Console\Commands;

use App\Jurisdiction;
use App\Statute;
use Illuminate\Console\Command;

class AddChapterNumberToStatutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmr:add-chapter-number-to-statutes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add chapter numbers to statutes from the number field';

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

        $records = Statute::select('number')
            ->where('jurisdiction_id',Jurisdiction::JURISDICTION_MO)
        ->get();

        foreach( $records AS $rec) {
            $statute = Statute::where('number', $rec->number)
                ->first();
            $parts = explode('.', $rec->number);
            print ".";
            $statute->chapter_number = $parts[0];
            $statute->save();
        }
        return 0;
    }
}
