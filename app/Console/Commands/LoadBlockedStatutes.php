<?php

namespace App\Console\Commands;

use App\Imports\CollectionImport;
use App\Statute;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class LoadBlockedStatutes extends Command
{
    public $chapter;
    public $file_name;
    public $type;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmr:load-blocked-statutes {--chapter=565} {--file=missouri-statutes-list.xlsx}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load Statutes';

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
        $this->info("Start: lbv:cmr:load-blocked-statutes");
        $this->file_name = $this->option('file');
        $this->chapter = $this->option('chapter');

        $data = $this->readSpreadSheet(base_path('data/') . $this->file_name);

        $data = $data->filter(function ($r) {
            return !Statute::where('number', $r['number'])->exists();
        })->unique('number');

        foreach ($data as $rec) {
            $this->info(sprintf(" Adding %-10.10s %s", $rec['number'], $rec['name']));
        }

        $this->info("Inserting {$data->count()} Records");

        Statute::insert($data->toArray());

        $this->info("End: lbv:cmr:load-blocked-statutes");

        return 0;
    }

    private function readSpreadSheet($spread_sheet_file_name)
    {
        $tmp = Excel::toCollection(new CollectionImport(), $spread_sheet_file_name)->first();


        if ($tmp->count()) {
            $tmp->skip(1);
            $tmp = $tmp->filter(function ($r) {
                return !empty($r[2]) && str_contains($r[2], $this->chapter . '.');
            })->map(function ($r) {
                return [
                    'number' => sprintf("%0.3f", $r[2]),
                    'name' => $r[3] ?? "",
                    'jurisdiction_id' => 1,
                    'blocks_time' => true,
                    'statutes_eligibility_id' => Statute::UNDETERMINED,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            });
        }

        $this->info("Found {$tmp->count()} records matching {$this->chapter}");

        return $tmp;
    }
}
