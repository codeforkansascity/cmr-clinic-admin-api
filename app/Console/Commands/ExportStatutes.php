<?php

namespace App\Console\Commands;

use App\Statute;
use Illuminate\Console\Command;
use Symfony\Component\Yaml\Yaml;

class ExportStatutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmr:export-statutes {--file=statutes.yaml}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export statutes to yaml';

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
        $statutes = Statute::with([
            'jurisdiction', 'jurisdiction.type', 'exceptions',
            'superseded' => function($q) {
                $q->with('jurisdiction', 'jurisdiction.type', 'exceptions', 'superseded');
            }
        ])->get()->toArray();

        $yaml = Yaml::dump($statutes, 6);

        file_put_contents(base_path('/data/'. $this->option('file')), $yaml);
        return 0;
    }
}
