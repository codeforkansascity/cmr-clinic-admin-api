<?php

namespace App\Console\Commands;

use App\Statute;
use Illuminate\Console\Command;
use Symfony\Component\Yaml\Yaml;


class ConvertStatutesToYaml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmr:convert-statutes-to-yaml';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert Statutes to Yaml format';

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

        $data = Statute::with(
            'superseded:id,number,name',
            'jurisdiction:id,name,jurisdiction_type_id',
            'jurisdiction.type:id,name',
            'exceptions:exceptions.id,exceptions.section,exceptions.name,exceptions.short_name,exceptions.attorney_note,exceptions.dyi_note,exceptions.logic'
        )
            ->select(
                'statutes.id',
                'statutes.number',
                'statutes.name',
                'statutes.common_name',
                'statutes.note',
                'statutes_eligibility_id',
                'statutes_eligibilities.name AS statutes_eligibility_name',
                'jurisdiction_id',
                'superseded_id'

            )
            ->whereIn('number',['568.030','568.032'])
            ->leftJoin('statutes_eligibilities','statutes_eligibilities.id','=','statutes_eligibility_id')
            ->get();

        return 0;
    }
}
