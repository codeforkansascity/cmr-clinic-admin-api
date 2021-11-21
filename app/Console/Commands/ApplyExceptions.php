<?php

namespace App\Console\Commands;

use App\Exception;
use App\ExceptionCodes;
use App\ImportMoRevisorActiveSection;
use App\ImportMshpChargeCodeManual;
use App\Jurisdiction;
use App\MshpVersion;
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


    private $mshp_version_id = 0;
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

        $mshp_version_system_name = '2021';
        $mshp_version = MshpVersion::select('id')->where('system_name',$mshp_version_system_name)->first();

        if (!$mshp_version) {
            $this->error('Unable to find MSHP Version system name ' . $mshp_version_system_name);
            die;
        }

        $this->mshp_version_id = $mshp_version->id;



        $this->do2_1();
        $this->do2_2();
        $this->do2_3();
        $this->do2_4();
        $this->do2_5();
        $this->do2_6();
	    $this->do2_7();
	    $this->do2_8();
        $this->do2_9();
	    $this->do2_10();
	    $this->do2_11();

        return 0;
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

        $mshp_version_id =  $this->mshp_version_id;

        $sql = <<<EOM
            select count(*) as cnt, cmr_law_number
            from (
               select cmr_law_number, type_class
                 from import_mshp_charge_code_manuals
                   where cmr_law_number in
                   (select cmr_law_number
                           from import_mshp_charge_code_manuals
                          where type_class = 'F / A'
                            and mshp_version_id = $mshp_version_id
                        group by cmr_law_number
                    )
                    and mshp_version_id = $mshp_version_id
                    group by cmr_law_number, type_class
                    order by cmr_law_number, type_class
                 ) as a
            group by cmr_law_number
EOM;

        $records = DB::select($sql);

        $applied_ids = [];

        foreach ($records as $rec) {
            $statute_id = Statute::getIdByNumber($rec->cmr_law_number, Jurisdiction::JURISDICTION_MO);
            $hasAttempt = $this->isStatuteAttempted($rec->cmr_law_number);

//
            if ($rec->cnt == 1) {       // For statutes that are only one Charge Code of a F/A (Felony A) we will mark them as Exception Applies
               if ($hasAttempt) {
                   StatuteException::updateOrCreate([
                       'statute_id' => $statute_id,
                       'exception_id' => $exception->id],
                       ['source' => 'Charge Code Manule 2021-2022',
                           'exception_code_id' => ExceptionCodes::POSSIBLY_APPLIES,
                           'note' => 'Can only be convicted as F/A and can be attempted'
                       ]);
               } else {
                   StatuteException::updateOrCreate([
                       'statute_id' => $statute_id,
                       'exception_id' => $exception->id],
                       ['source' => 'Charge Code Manule 2021-2022',
                           'exception_code_id' => ExceptionCodes::APPLIES,
                           'note' => 'Can only be convicted as F/A'
                       ]);
               }



                $applied_ids[] = $statute_id;

            } else { // For statutes where there are both F/A and other levels in the Charge Codes, we will mark them Exception Possibly Applies

                if ($hasAttempt) {
                    StatuteException::updateOrCreate([
                        'statute_id' => $statute_id,
                        'exception_id' => $exception->id],
                        ['source' => 'Charge Code Manule 2021-2022',
                            'exception_code_id' => ExceptionCodes::POSSIBLY_APPLIES,
                            'attorney_note' => 'Use charge code or research using the conviction Date and Level to determine eligibility',
                            'dyi_note' => 'Use the Charge Code of the conviction to determine elegibility',
                            'note' => 'Conviction can be less than F/A and can be attempted'
                        ]);
                } else {
                    StatuteException::updateOrCreate([
                        'statute_id' => $statute_id,
                        'exception_id' => $exception->id],
                        ['source' => 'Charge Code Manule 2021-2022',
                            'exception_code_id' => ExceptionCodes::POSSIBLY_APPLIES,
                            'attorney_note' => 'Use charge code or research using the conviction Date and Level to determine eligibility',
                            'dyi_note' => 'Use the Charge Code of the conviction to determine elegibility',
                            'note' => 'Conviction can be less than F/A'
                        ]);
                }

                $applied_ids[] = $statute_id;
            }
        }

        // For all other statutes, mark as Does Not Apply.
       // $this->inverse($exception->id, $applied_ids, 'Charge Code Manule 2021-2022', 'Cannot be charged as a Felony A per Charge Code Manule');

        $statutes = Statute::whereNotIn('id', $applied_ids)->get();
        $this->applyException($exception, null, $statutes, '', ExceptionCodes::DOES_NOT_APPLY);

    }

    private function isStatuteAttempted($cms_law_number) {
        $cnt = ImportMshpChargeCodeManual::where('mshp_version_id',$this->mshp_version_id)
            ->where('cmr_law_number', $cms_law_number)
            ->where('cmr_attempt',1)
            ->groupBy('cmr_law_number')
            ->count();


        return $cnt;
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

            $this->applyException($exception, $numbers, $statutes, 'Please Research and assign exception code', ExceptionCodes::RESEARCH);

            $felonyALawNumbers = $this->hasFelony()->pluck('cmr_law_number');

            $this->applyNotFelonyA2_2($exception->id, $felonyALawNumbers);

        } else {
            $this->error('Exception 2.2 was not found');
        }
    }

    private function applyNotFelonyA2_2($exception_id, $felonyALawNumbers)
    {

        // For all statutes that cannot be charged as a Felony, mark Does Not Apply.
        $records = Statute::select('id','number')
            ->whereNotIn('number', $felonyALawNumbers)
            ->where('jurisdiction_id', Jurisdiction::JURISDICTION_MO)
            ->get();

        // Ends up reporting what will become undetermined
//        if ($felonyALawNumbers) {
//            $found_numbers = $records->pluck('number');
//
//            $not_found_numbers = array_diff($felonyALawNumbers->toArray(),$found_numbers->toArray());
//
//            if ($not_found_numbers) {
//                $this->error("Error: statutes not found:");
//                foreach ($not_found_numbers AS $missing_number) {
//                    $this->error("    $missing_number");
//                }
//            }
//        }

        foreach ($records as $rec) {

            StatuteException::updateOrCreate([
                'statute_id' => $rec->id,
                'exception_id' => $exception_id],
                ['source' => 'Charge Code Manule 2021-2022',
                    'exception_code_id' => ExceptionCodes::DOES_NOT_APPLY,
                    'dyi_note' => '--',
                    'attorney_note' => 'Cannot be charged as a Felony A per Charge Code Manule',
                    'note' => 'Cannot be charged as a Felony A per Charge Code Manule',
                ]);
        }

        return  $records->pluck('cmr_law_number');

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
            ->where('mshp_version_id',$this->mshp_version_id)
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

            if ($rec->cnt == $rec->sor_cnt) {  // For statutes that all Charge Codes have SOR = Y, mark as Exception Applies.
                StatuteException::updateOrCreate([
                    'statute_id' => $statute_id,
                    'exception_id' => $exception->id],
                    ['source' => $source,
                        'exception_code_id' => ExceptionCodes::APPLIES
                    ]);

                $applied_ids[] = $statute_id;

            } else {  // In the case where there is a mix of Y/N in SOR in the Charge Codes for a statute, mark Exception Possibly Applies.

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

        // All other statutes, mark Exception Does Not Apply.
    //    $this->inverse($exception->id, $applied_ids, $source, 'Does not require registration on sex offendor list');

//        $statutes = Statute::whereNotIn('id', $applied_ids)->get();
//        $this->applyException($exception, $statutes, '', ExceptionCodes::DOES_NOT_APPLY);

        $this->inversIds($exception,$applied_ids);

    }

    private function do2_4()
    {
        $this->info('Section 2.4');
        if ($exception = Exception::where('section', '2.4')->first()) {

            // One of the “causes the death of…” from 565.020 through .034

            $cause_of_death_numbers = [
                "565.020",
                "565.021",
                "565.023",
                "565.024",
                "565.027",


            ];

            $statutes = Statute::whereIn('number', $cause_of_death_numbers)
                //   ->whereNotIn('number',$felonyALawNumbers)
                ->get();
            $this->applyException($exception, $cause_of_death_numbers, $statutes, 'One of the “causes the death of…” from 565.020 through .034', ExceptionCodes::APPLIES);

            // Mark not felonies

            $felonyALawNumbers = $this->hasFelony()->pluck('cmr_law_number');
            // For all statutes that can not be charged as a Felony, mark Does Not Apply.
            $notFelonyNumbers = $this->applyNotFelonyA2_2($exception->id, $felonyALawNumbers);



            $numbers = [
                "565.029",
                "565.030",
                "565.032",
                "565.033",
                "565.034",

                '198.070',  // In list Search of Charge Code Manule where ‘DEATH’ is in the description and is a Felony
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
                '574.080',  // Catastorophe
            ];

            // Research ones in list
            $statutes = Statute::whereIn('number', $numbers)
             //   ->whereNotIn('number',$felonyALawNumbers)
                ->get();
            $this->applyException($exception, $numbers, $statutes, 'Please Research and assign exception code, DEATH was in Charge Code Description', ExceptionCodes::RESEARCH);

            // For all other statutes, mark as Does Not Apply.
//            $this->inverse($exception->id, array_merge($cause_of_death_numbers,$notFelonyNumbers->toArray(),$numbers
//            ), 'Charge Code Manule 2021-2022', '');

            $statutes = Statute::whereNotIn('number', array_merge($cause_of_death_numbers,$notFelonyNumbers->toArray(),$numbers
            ))->get();
            $this->applyException($exception, null, $statutes, '', ExceptionCodes::DOES_NOT_APPLY);


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
//                '565.056',
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

            $query = Statute::whereIn('number', $numbers);
            $numbers = $this->apply($numbers,$exception,$query, ExceptionCodes::RESEARCH, 'Please Research and assign exception code');

            $this->inversNumbers($exception,$numbers);


        } else {
            $this->error('Exception 2.5 was not found');
        }
    }

    private function do2_6()
    {
        $this->info('Section 2.6');

        if ($exception = Exception::where('section', '2.6')->first()) {
            $numbers = $this->section_2_6();
            $query = Statute::whereIn('number', $numbers);
            $listed_numbers = $this->apply($numbers,$exception,$query, ExceptionCodes::APPLIES);

            $repeal_transferred_numbers = ['217.360',
                '565.084',
                '565.085',
                '565.086',
                '565.095',
                '565.200',
                '565.214',
                '568.080',
                '568.090',
                '569.030',
                '569.035',
                '569.067',
                '569.072',
                '575.350',
                '577.054',
                '578.008',
                '578.305',
                '578.310'];



            $query = Statute::whereIn('number', $repeal_transferred_numbers);
            $repeal_transferred_numbers =  $this->apply($repeal_transferred_numbers,$exception,$query, ExceptionCodes::RESEARCH,'Repealed or Transfered by S.B. 491, 2014, effective 1-01-17',$listed_numbers);

            $query = Statute::where('number', 'like', '566%');
            $in_566 =  $this->apply(null, $exception,$query, ExceptionCodes::RESEARCH,'',array_merge($listed_numbers, $repeal_transferred_numbers));

            $this->inversNumbers($exception,array_merge($listed_numbers, $repeal_transferred_numbers, $in_566));

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

        if ($exception = Exception::where('section', '2.7')->first()) {

            $numbers = [
                '577.010',
                '577.012',
                '577.013',
                '577.014',
                '577.015',
                '577.016',
                '577.017',
            ];

            $query = Statute::whereIn('number', $numbers);
            $numbers = $this->apply($numbers,$exception,$query, ExceptionCodes::RESEARCH, 'Please Research and assign exception code');

            $this->inversNumbers($exception,$numbers);

        } else {
            $this->error('Exception 2.7 was not found');
        }

    }

    private function do2_8()
    {
        $this->info('Section 2.8');

        if ($exception = Exception::where('section', '2.8')->first()) {


            $numbers = [
                '577.010',
                '577.012',
                '577.013',
                '577.014',
                '577.015',
                '577.016',
                '577.017',
                '557.024',
                '557.025'
            ];

            $query = Statute::whereIn('number', $numbers);
            $numbers = $this->apply($numbers,$exception,$query, ExceptionCodes::RESEARCH, 'Please Research and assign exception code');

            $this->inversNumbers($exception,$numbers);

        } else {
            $this->error('Exception 2.8 was not found');
        }

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

        if ($exception = Exception::where('section', '2.10')->first()) {

            $traffic_numbers = $this->getTraffic();

            $query = Statute::whereIn('number', $traffic_numbers);
            $numbers = $this->apply($traffic_numbers, $exception,$query, ExceptionCodes::RESEARCH, 'Please Research and assign exception code');

            $this->inversNumbers($exception,$numbers);

        } else {
            $this->error('Exception 2.10 was not found');
        }

    }

    private function do2_11()
    {
        $this->info('Section 2.11');

        if ($exception = Exception::where('section', '2.11')->first()) {

            $query = Statute::where('number', '571.030');
            $numbers = $this->apply(['571.030'], $exception,$query, ExceptionCodes::POSSIBLY_APPLIES);

            $this->inversNumbers($exception,$numbers);

        } else {
            $this->error('Exception 2.11 was not found');
        }

    }

    private function inversNumbers($exception,$numbers) {
        $query = Statute::whereNotIn('number', $numbers);
        $this->apply($numbers, $exception,$query,ExceptionCodes::DOES_NOT_APPLY);

    }

    private function inversIds($exception,$ids) {
        $query = Statute::whereNotIn('id', $ids);
        $this->apply(null,$exception,$query,ExceptionCodes::DOES_NOT_APPLY);

    }

    private function apply($numbers,$exception,$query,$exception_code,$note='',$notin = false) {
        if ($numbers) {
            $this->findOrAddStatutes($numbers);
        }

        $query->where('jurisdiction_id', Jurisdiction::JURISDICTION_MO);
        if ($notin) {
            $query->whereNotIn('number',$notin);
        }
        $statutes = $query->get();

        $this->applyException($exception, null, $statutes, $note, $exception_code);

        return $statutes->pluck('number')->toArray();
    }


    private function applyException($exception, $numbers, $statutes, $note = '', $exception_code_id = null, $attorney_note=null, $dyi_note=null)
    {

        // // Ends up reporting what will become undetermined
//        if ($numbers) {
//            $found_numbers = $statutes->pluck('number');
//
//            $not_found_numbers = array_diff($numbers,$found_numbers->toArray());
//
//            if ($not_found_numbers) {
//                $this->error("Error: statutes not found:");
//                foreach ($not_found_numbers AS $missing_number) {
//                    $this->error("    $missing_number");
//                }
//            }
//        }

        if ($numbers) {
            $this->findOrAddStatutes($numbers);
        }



        foreach ($statutes as $statute) {
            StatuteException::updateOrCreate([
                'statute_id' => $statute->id,
                'exception_id' => $exception->id],
                ['note' => $note,
                    'exception_code_id' => $exception_code_id,
                    'attorney_note' => $attorney_note,
                    'dyi_note' => $dyi_note,

                ]);
        }
    }

    private function findOrAddStatutes($statute_numbers)
    {

        foreach ($statute_numbers as $statute_number) {

            $found_statute_number = Statute::where('number', $statute_number)->count();

            if (!$found_statute_number) {

                $active = ImportMoRevisorActiveSection::where('number', $statute_number)
                    ->where('jurisdiction_id',Jurisdiction::JURISDICTION_MO)
                    ->first();

                if ($active && $active->description) {
                    $name = $active->description;
                } else {
                    $name = 'Added when apply-exceptions. Might have been repealed or missing charge code - please FIX';
                }

                $parts = explode('.', $statute_number);

                $record = [
                    'number' => $statute_number,
                    'name' => $name,
                    'note' => '',
                    'chapter_number' => $parts[0],
                    'jurisdiction_id' => Jurisdiction::JURISDICTION_MO,
                    'statutes_eligibility_id' => Statute::UNDETERMINED
                ];

                Statute::create($record);

                $this->info("    Added $statute_number: $name");
            }
        }

    }

    private function hasFelony()
    {

        return ImportMshpChargeCodeManual::select('cmr_law_number')
            ->where('type_class', 'like', 'F%')
            ->where('mshp_version_id',$this->mshp_version_id)
            ->groupBy('cmr_law_number')
            ->get();
    }

    private function getTraffic() {
        $traffic_numbers = [];
        $statutes = Statute::where('number', 'like', '301%')->get();
        $traffic_numbers = array_merge($statutes->pluck('number')->toArray());

        $statutes = Statute::where('number', 'like', '302%')->get();
        $traffic_numbers = array_merge($statutes->pluck('number')->toArray());
        $statutes = Statute::where('number', 'like', '303%')->get();
        $traffic_numbers = array_merge($statutes->pluck('number')->toArray());
        $statutes = Statute::where('number', 'like', '304%')->get();
        $traffic_numbers = array_merge($statutes->pluck('number')->toArray());
        $statutes = Statute::where('number', 'like', '305%')->get();
        $traffic_numbers = array_merge($statutes->pluck('number')->toArray());
        $statutes = Statute::where('number', 'like', '306%')->get();
        $traffic_numbers = array_merge($statutes->pluck('number')->toArray());
        $statutes = Statute::where('number', 'like', '307%')->get();
        $traffic_numbers = array_merge($statutes->pluck('number')->toArray());

        return $traffic_numbers;
    }





}
