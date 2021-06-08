<?php

namespace App\Console\Commands;

use App\Imports\CollectionImport;
use App\Statute;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class UpdateCommonName extends Command
{
    public $chapters;
    public $file_name;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmr:update-common  {--chapters=574,570} {--file=missouri-statutes-list.xlsx}';

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
    public function handle()
    {
        $this->info("Start: lbv:load-trash-contract-pricing");
        $this->file_name = $this->option('file');
        $this->chapters = explode(',', $this->option('chapters'));

        $data = $this->readSpreadSheet(base_path('data/') . $this->file_name);

        $existing = Statute::whereIn('number', $data->pluck('number'))->get()
            ->flatMap(function ($s) {
                return [$s->number => $s];
            });

        // update records
        $updateCount = 0;
        foreach ($data as $row) {
            if (isset($existing[$row['number']]) && $existing[$row['number']]->name !== $row['name']) {
                $model = $existing[$row['number']];
                $model->common_name = substr($model->name, 0, 191);
                $model->name = $row['name'];
                $model->save();
                $updateCount++;
            }
        }
        $this->info("Updated {$updateCount} Records");


        return 0;
    }

    private function readSpreadSheet($spread_sheet_file_name)
    {
        $tmp = Excel::toCollection(new CollectionImport(), $spread_sheet_file_name)->first();


        if ($tmp->count()) {
            $tmp->skip(1);
            $tmp = $tmp->filter(function ($r) {
                $part = preg_replace('/\.\d*/', '', $r[2] ?? "");
                return !empty($r[2]) && in_array($part, $this->chapters);
            })->map(function ($r) {
                return [
                    'number' => sprintf("%0.3f", $r[2]),
                    'name' => $r[3] ?? "",
                    'jurisdiction_id' => 1,
                    'blocks_time' => false,
                ];
            });
        }

        $this->info("Found {$tmp->count()} records matching ". implode(', ', $this->chapters));

        return $tmp;
    }
}
