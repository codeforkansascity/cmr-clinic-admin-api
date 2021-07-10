<?php

namespace App\Console\Commands;

use App\Exception;
use App\Jurisdiction;
use App\JurisdictionType;
use App\Models\Law;
use App\Models\LawVersion;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Yaml\Yaml;

class ImportLaws extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmr:import-laws {--file=statutes.yaml}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Laws from yaml';
    private $jusrisdiction_types;
    private $jusrisdictions;
    /**
     * @var array|bool|string|null
     */
    private $file_name;
    private $exceptions;
    private $lawIdIndex = [];
    /**
     * @var mixed
     */
    private $laws;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->jusrisdictions = Jurisdiction::with('type')->get()->flatMap(function ($j) {
            return [$this->makeKey($j) => $j];
        });
        $this->jusrisdiction_types = JurisdictionType::get()->flatMap(function ($j) {
            return [$this->makeKey($j) => $j];
        });
        $this->exceptions = Exception::get()->flatMap(function ($e) {
            return [$e->section => $e];
        });
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->file_name = $this->option('file');
        $this->laws = Yaml::parseFile(base_path('/data/') . $this->file_name);

        // map previous law id to current index in array
        foreach ($this->laws as $key => $law) {
            $this->lawIdIndex[$law['id']] = $key;
        }

        DB::unprepared('set FOREIGN_KEY_CHECKS=0');

        $this->info("Laws before " . Law::count());
        dump("Laws before " . Law::count());
        foreach ($this->laws as $law) {
//print_r($law);
            print ".";
            $test = LawVersion::findByNumber($law['number']);
//            print_r($test->toArray());
            if (!LawVersion::findByNumber($law['number'])) {
                print "+";
                $this->createLaw($law);
            }

        }
        $this->info("Laws after " . Law::count());
        dump("Laws after " . Law::count());
        DB::unprepared('set FOREIGN_KEY_CHECKS=1');

        return 0;
    }

    private function createLaw($law)
    {

        print("|" . $law['number'] . "|\n");

        $jurisdiction = !empty($law['jurisdiction']) ? $this->matchJurisdiction($law['jurisdiction']) : null;

        if (!empty($law['superseded_id'])
            && $law['superseded_id'] != $law['id']
            && ($supersededIndex = $this->findIndexById($law['superseded_id']))
        ) {
            $supersededImport = $this->laws[$supersededIndex];
            $superseded = LawVersion::findByNumber($supersededImport['number']);
            if (!$superseded) {
                $superseded = $this->createLaw($supersededImport);
            }
            $superseded_id = $superseded->id;
        }

        DB::beginTransaction();
        $record = Law::create();
        $version_record = LawVersion::create(
            [
                "law_id" => $record->id,
                "version_status" => LawVersion::APPROVED,
                "number" => $law['number'],
                "name" => $law['name'],
                "note" => $law['note'],
                "law_eligibility_id" => $law['statutes_eligibility_id'],
                "superseded_id" => $superseded_id ?? null,
                "superseded_on" => $law['superseded_on'],
                "deleted_at" => $law['deleted_at'],
                "jurisdiction_id" => $jurisdiction->id ?? null,
                "same_as_id" => $law['same_as_id'],
                "common_name" => $law['common_name'],
                "blocks_time" => $law['blocks_time'],
            ]
        );

        $record->law_version_id = $version_record->id;
        $record->save();


        if (!empty($law['exceptions'])) {
            $synced = [];
            foreach ($law['exceptions'] as $exception) {
                $match = $this->matchException($exception);
                $synced [$match->id] = ['note' => $exception['pivot']['note'] ?? null];
            }
            $version_record->exceptions()->sync($synced);
        }

        DB::commit();

        return $record;
    }

    private function matchJurisdiction($jurisdiction)
    {
        if (isset($this->jusrisdictions[$this->makeKey($jurisdiction)])) {
            return $this->jusrisdictions[$this->makeKey($jurisdiction)];
        }

        // create jurisdiction
        return $this->createJurisdiction($jurisdiction);
    }

    private function makeKey($object)
    {

        if (is_array($object)) {
            return isset($object['type']) ? $object['name'] . '---' . $object['type']['name'] : $object['name'];
        }
        return isset($object->type) ? $object->name . '---' . $object->type->name : $object->name;
    }

    private function createJurisdiction($jurisdiction)
    {
        $type = $this->matchJurisdictionType($jurisdiction['type']);

        $data = [
            'jurisdiction_type_id' => $type->id,
            'name' => $jurisdiction['name'],
        ];
        $newJurisdiction = Jurisdiction::create($data);
        $this->jusrisdictions[$this->makeKey($newJurisdiction)] = $newJurisdiction;

        return $newJurisdiction;
    }

    private function matchJurisdictionType($type)
    {
        if (isset($this->jusrisdiction_types[$this->makeKey($type)])) {
            return $this->jusrisdiction_types[$this->makeKey($type)];
        }

        // create jurisdiction
        return $this->createJurisdictionType($type);
    }

    private function createJurisdictionType($type)
    {
        $data = [
            'name' => $type['name'],
        ];
        $newJurisdictionType = JurisdictionType::create($data);
        $this->jusrisdiction_types[$this->makeKey($newJurisdictionType)] = $newJurisdictionType;

        return $newJurisdictionType;
    }

    private function matchException($exception)
    {
        if (isset($this->exceptions[$exception['section']])) {
            return $this->exceptions[$exception['section']];
        }

        // create jurisdiction
        return $this->createException($exception);
    }

    private function createException($exception)
    {

        $data = [
            'name' => $exception['name'],
            'short_name' => $exception['short_name'],
            'section' => $exception['section'],
            'attorney_note' => $exception['attorney_note'],
            'dyi_note' => $exception['dyi_note'],
            'logic' => $exception['logic']
        ];

        $newException = Exception::create($data);
        $this->exceptions[$newException->section] = $newException;

        return $newException;
    }

    private function findIndexById($id)
    {
        return $this->lawIdIndex[$id] ?? null;
    }
}
