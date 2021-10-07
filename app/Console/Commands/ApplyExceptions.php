<?php

namespace App\Console\Commands;

use App\Exception;
use App\ExceptionCodes;
use App\ImportMshpChargeCodeManual;
use App\Jurisdiction;
use App\Statute;
use App\StatuteException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ApplyExceptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmr:apply-exceptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Apply exceptions to statutes';

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

        $this->do2_1();
        $this->do2_2();
        $this->do2_3();
        $this->do2_4();
        $this->do2_5();
        $this->do2_6();
//	    $this->do2_7();
//	    $this->do2_8();
        $this->do2_9();
//	    $this->do2_10();
	    $this->do2_11();

        return 0;
    }

    private function applyException($exception, $statutes, $note = '', $exception_code_id = null)
    {
        foreach ($statutes as $statute) {
            StatuteException::updateOrCreate([
                'statute_id' => $statute->id,
                'exception_id' => $exception->id],
                ['note' => $note,
                    'exception_code_id' => $exception_code_id
                ]);
        }
    }


    private function do2_1()
    {
        $this->info('Section 2.1');

        if ($exception = Exception::where('section', '2.1')->first()) {

            $this->applySection_2_1($exception);

        } else {
            $this->error('Exception 2.1 was not found');
        }
    }

    private function applySection_2_1($exception)
    {

        $sql = <<<EOM
            select count(*) as cnt, cmr_law_number
            from (
               select cmr_law_number, type_class
                 from import_mshp_charge_code_manuals
                   where cmr_law_number in
                   (select cmr_law_number
                           from import_mshp_charge_code_manuals
                          where type_class = 'F / A'
                        group by cmr_law_number)
                    group by cmr_law_number, type_class
                    order by cmr_law_number, type_class
                 ) as a
            group by cmr_law_number
EOM;

        $records = DB::select($sql);

        $applied_ids = [];

        foreach ($records as $rec) {
            $statute_id = Statute::getIdByNumber($rec->cmr_law_number, Jurisdiction::JURISDICTION_MO);

            if ($rec->cnt == 1) {
                StatuteException::updateOrCreate([
                    'statute_id' => $statute_id,
                    'exception_id' => $exception->id],
                    ['source' => 'Charge Code Manule 2021-2022',
                        'exception_code_id' => ExceptionCodes::APPLIES
                    ]);

                $applied_ids[] = $statute_id;

            } else {
                StatuteException::updateOrCreate([
                    'statute_id' => $statute_id,
                    'exception_id' => $exception->id],
                    ['source' => 'Charge Code Manule 2021-2022',
                        'exception_code_id' => ExceptionCodes::POSSIBLY_APPLIES,
                        'attorney_note' => 'Use charge code or research using the conviction Date and Level to determine eligibility',
                        'dyi_note' => 'Use the Charge Code of the conviction to determine elegibility',
                    ]);

                $applied_ids[] = $statute_id;
            }
        }

        $this->inverse($exception->id, $applied_ids, 'Charge Code Manule 2021-2022', 'Cannot be charged as a Felony A per Charge Code Manule');

    }

    private function inverse($exception_id, $applied_ids, $source, $note)
    {
        $records = Statute::select('id')
            ->whereNotIn('id', $applied_ids)
            ->where('jurisdiction_id', Jurisdiction::JURISDICTION_MO)
            ->get();

        foreach ($records as $rec) {

            StatuteException::updateOrCreate([
                'statute_id' => $rec->id,
                'exception_id' => $exception_id],
                ['source' => $source,
                    'exception_code_id' => ExceptionCodes::DOES_NOT_APPLY,
                    'attorney_note' => $note,
                    'dyi_note' => '--',
                ]);
        }
    }

    private function do2_2()
    {
        $this->info('Section 2.2');
        if ($exception = Exception::where('section', '2.2')->first()) {
            $numbers = [
                '569.040',
//                '569.050',
//                '569.053',
//                '569.055',
//                '569.060',
//                '569.065',
            ];

            $statutes = Statute::whereIn('number', $numbers)->get();
            $this->applyException($exception, $statutes, 'Please Research and assign exception code', ExceptionCodes::RESEARCH);

            $felonyALawNumbers = $this->hasFelony()->pluck('cmr_law_number');

            $this->applyNotFelonyA2_2($exception->id, $felonyALawNumbers);

        } else {
            $this->error('Exception 2.2 was not found');
        }
    }

    private function hasFelony()
    {

        return ImportMshpChargeCodeManual::select('cmr_law_number')
            ->where('type_class', 'like', 'F%')
            ->groupBy('cmr_law_number')
            ->get();
    }

    private function applyNotFelonyA2_2($exception_id, $felonyALawNumbers)
    {

        $records = Statute::select('id')
            ->whereNotIn('number', $felonyALawNumbers)
            ->where('jurisdiction_id', Jurisdiction::JURISDICTION_MO)
            ->get();

        foreach ($records as $rec) {

            StatuteException::updateOrCreate([
                'statute_id' => $rec->id,
                'exception_id' => $exception_id],
                ['source' => 'Charge Code Manule 2021-2022',
                    'exception_code_id' => ExceptionCodes::DOES_NOT_APPLY,
                    'dyi_note' => '--',
                    'attorney_note' => 'Cannot be charged as a Felony A per Charge Code Manule',
                ]);
        }
    }


    private function do2_3()
    {
        $this->info('Section 2.3');
        if ($exception = Exception::where('section', '2.3')->first()) {

            $this->applySection_2_3($exception);

        } else {
            $this->error('Exception 2.3 was not found');
        }
    }

    private function applySection_2_3($exception)
    {

        $query = ImportMshpChargeCodeManual::select(
            'cmr_law_number',
            'effective_date',
            DB::raw("sum(1) as cnt"),
            DB::raw("sum(if (sor = 'Y', 1, 0)) as sor_cnt")
        )
            ->where('mshp_version_id', 2)
            ->groupBy('cmr_law_number', 'effective_date')
            ->orderBy('cmr_law_number')
            ->orderBy('effective_date')
            ->having('sor_cnt', '>', 0);

//        print $query->toSql() . "\n\n";

        $records = $query->get();
        $applied_ids = [];
        $source = 'Charge Code Manule 2021-2022 SOR Field';
        foreach ($records as $rec) {
            $statute_id = Statute::getIdByNumber($rec->cmr_law_number, Jurisdiction::JURISDICTION_MO);

            if ($rec->cnt == $rec->sor_cnt) {
                StatuteException::updateOrCreate([
                    'statute_id' => $statute_id,
                    'exception_id' => $exception->id],
                    ['source' => $source,
                        'exception_code_id' => ExceptionCodes::APPLIES
                    ]);

                $applied_ids[] = $statute_id;

            } else {
                StatuteException::updateOrCreate([
                    'statute_id' => $statute_id,
                    'exception_id' => $exception->id],
                    ['source' => $source,
                        'exception_code_id' => ExceptionCodes::POSSIBLY_APPLIES,
                        'attorney_note' => 'To determine if this is expungable or not use Charge code or research using the conviction Date and Level',
                        'dyi_note' => 'Use the Charge Code of the conviction to determine elegibility',
                    ]);

                $applied_ids[] = $statute_id;
            }
        }

        $this->inverse($exception->id, $applied_ids, $source, 'Does not require registration on sex offendor list');

    }

    private function do2_4()
    {
        $this->info('Section 2.4');
        if ($exception = Exception::where('section', '2.4')->first()) {

            $numbers = [
                '565.020',
                '565.021',
                '565.023',
                '565.024',
                '565.027',
            ];

            $statutes = Statute::whereIn('number', $numbers)->get();
            $this->applyException($exception, $statutes, 'Please Research and assign exception code', ExceptionCodes::RESEARCH);

            $numbers = [
                '198.070',
                '304.050',
                '389.653',
                '566.203',
                '566.206',
                '566.209',
                '568.030',
                '568.032',
                '568.045',
                '568.045',
                '568.060',
                '568.060',
                '569.040',
                '569.040',
                '569.050',
                '571.030',
                '575.150',
                '575.353',
                '577.010',
                '577.010',
                '577.010',
                '577.010',
                '577.013',
                '577.013',
                '577.060',
                '577.075',
                '577.078',
                '578.024',
                '579.055',
                '650.520',
            ];

            $statutes = Statute::whereIn('number', $numbers)->get();
            $this->applyException($exception, $statutes, 'Please Research and assign exception code, DEATH was in Charge Code Description', ExceptionCodes::RESEARCH);

            $felonyALawNumbers = $this->hasFelony()->pluck('cmr_law_number');

            $this->applyNotFelonyA2_2($exception->id, $felonyALawNumbers);

        } else {
            $this->error('Exception 2.4 was not found');
        }
    }

    private function do2_5()
    {
        $this->info('Section 2.5');
        if ($exception = Exception::where('section', '2.5')->first()) {

            $numbers = [
                '565.052',
                '565.054',
                '565.056',
                '565.072',
                '565.073',
                '565.074',
                '565.076',
                '565.110',
                '565.115',
                '565.120',
                '565.130',
//                '565.140',
                '565.150',
                '565.153',
                '565.156',
//                '565.160',
//                '565.163',
//                '565.167',
            ];

            $statutes = Statute::whereIn('number', $numbers)->get();
            $this->applyException($exception, $statutes, 'Please Research and assign exception code', ExceptionCodes::RESEARCH);

        } else {
            $this->error('Exception 2.5 was not found');
        }
    }

    private function do2_6()
    {
        $this->info('Section 2.6');

        if ($exception = Exception::where('section', '2.6')->first()) {
            $numbers = $this->section_2_6();

            $statutes = Statute::whereIn('number', $numbers)->get();
            $listed_numbers = $statutes->pluck('number')->toArray();
            $this->applyException($exception, $statutes, '', ExceptionCodes::APPLIES);

            $statutes = Statute::where('number', 'like', '566%')->get();
            $in_566 = $statutes->pluck('number')->toArray();
            $this->applyException($exception, $statutes, '', ExceptionCodes::APPLIES);

            $query = Statute::whereNotIn('number', array_merge($listed_numbers, $in_566))
                ->where('jurisdiction_id', Jurisdiction::JURISDICTION_MO);

            $statutes = $query->get();
            $this->applyException($exception, $statutes, '', ExceptionCodes::DOES_NOT_APPLY);

        } else {
            $this->error('Exception 2.6 was not found');
        }

    }

    private function section_2_6()
    {

        return ['105.454', '105.478', '115.631', '130.028', '188.030', '188.080',
            '191.677', '194.425', '217.360', '217.385', '334.245', '375.991',
            '389.653', '455.085', '455.538', '557.035', '565.084', '565.085',
            '565.086', '565.095', '565.120', '565.130', '565.156', '565.200',
            '565.214', '566.093', '566.115', '568.020', '568.030',
            '568.032', '568.045', '568.060', '568.065', '568.080', '568.090',
            '568.175', '569.030', '569.035', '569.040', '569.050', '569.055',
            '569.060', '569.065', '569.067', '569.072', '569.160', '570.025',
            '570.090', '570.180', '570.223', '570.224', '570.310', '571.020',
            '571.060', '571.063', '571.070', '571.072', '571.150', '574.070',
            '574.105', '574.115', '574.120', '574.130', '575.040', '575.095',
            '575.153', '575.155', '575.157', '575.159', '575.195', '575.200',
            '575.210', '575.220', '575.230', '575.240', '575.350', '575.353',
            '577.078', '577.703', '577.706', '578.008', '578.305', '578.310',
            '632.520'];
    }

    private function do2_7()
    {
        $this->info('Section 2.7');

    }

    private function do2_8()
    {
        $this->info('Section 2.8');

    }

    private function do2_9()
    {
        $this->info('Section 2.9');

        if ($exception = Exception::where('section', '2.9')->first()) {

            $records = Statute::select('id')
                ->where('jurisdiction_id', Jurisdiction::JURISDICTION_MO)
                ->get();

            foreach ($records as $rec) {

                StatuteException::updateOrCreate([
                    'statute_id' => $rec->id,
                    'exception_id' => $exception->id],
                    ['source' => 'All MO Statutes',
                        'exception_code_id' => ExceptionCodes::DOES_NOT_APPLY,
                        'attorney_note' => 'Cannot be an ordinance violation since it is a Missouri Statute',
                        'dyi_note' => '--',
                    ]);
            }

        } else {
            $this->error('Exception 2.9 was not found');
        }
    }

    private function do2_10()
    {
        $this->info('Section 2.10');

    }

    private function do2_11()
    {
        $this->info('Section 2.11');

        if ($exception = Exception::where('section', '2.11')->first()) {

            $statutes = Statute::where('number', '571.030')->get();
            $this->applyException($exception, $statutes, '', ExceptionCodes::APPLIES);

            $query = Statute::where('number', '<>', '571.030')
                ->where('jurisdiction_id', Jurisdiction::JURISDICTION_MO);

            $statutes = $query->get();
            $this->applyException($exception, $statutes, '', ExceptionCodes::DOES_NOT_APPLY);

        } else {
            $this->error('Exception 2.11 was not found');
        }

    }

}
