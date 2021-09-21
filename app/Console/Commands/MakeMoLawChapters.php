<?php

namespace App\Console\Commands;

use App\ImportMoRevisorStatute;
use App\Jurisdiction;
use App\LawChapter;
use Illuminate\Console\Command;

class MakeMoLawChapters extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmr:make-mo-law-chapter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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


//        select cmr_chapter, chapter_name
//        from import_mo_revisor_statutes
//        where cmr_chapter <> 0
//        group by cmr_chapter,
//        chapter_name order by cmr_chapter;

        $query = ImportMoRevisorStatute::select('cmr_chapter', 'chapter_name')
            ->where('cmr_chapter', '<>', 0)
            ->groupBy('cmr_chapter', 'chapter_name')
            ->orderBy('cmr_chapter');


        print $query->toSql();  print "\n";

        $chapters = $query->get();

        foreach ($chapters AS $chapter) {
            if (!($rec = LawChapter::where('chapter_number',$chapter->cmr_chapter)->first())) {
                LawChapter::create([
                    'jurisdiction_id' => Jurisdiction::JURISDICTION_MO,
                    'chapter_number' => $chapter->cmr_chapter,
                    'chapter_title' => $chapter->chapter_name
                ]);
            }
        }
        return 0;

    }
}
