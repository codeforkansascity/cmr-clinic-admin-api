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
    protected $description = 'Applie exceptions to statutes';

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

        if ($exception = Exception::where('section', '2.3')->first()) {

            $this->applySection_2_3($exception);

        } else {
            $this->error('Exception 2.4 was not found');
        }

        if ($exception = Exception::where('section', '2.4')->first()) {

            $statutes = Statute::whereIn('number',['565.020'])->get();
            $this->applyException($exception,$statutes,'Special Note about 2.4 and 565.020');

        } else {
            $this->error('Exception 2.4 was not found');
        }


        if ($exception = Exception::where('section', '2.6')->first()) {
            $numbers = $this->section_2_6();

            $statutes = Statute::whereIn('number',$numbers)->get();
            $this->applyException($exception,$statutes,'',ExceptionCodes::APPLIES);

            $statutes = Statute::where('number','like', '566%')->get();
            $this->applyException($exception,$statutes,'',ExceptionCodes::APPLIES);
        } else {
            $this->error('Exception 2.6 was not found');
        }


        return 0;
    }

    private function applyException($exception,$statutes,$note='',$exception_code_id=null) {
        foreach ($statutes AS $statute) {
            StatuteException::create([
                'statute_id' => $statute->id,
                'exception_id' => $exception->id,
                'note' => $note,
                'exception_code_id' => $exception_code_id
            ]);
        }
    }

    private function section_2_6() {

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

    private function applySection_2_3($exception) {

        $query = ImportMshpChargeCodeManual::select(
            'cmr_law_number',
            'effective_date',
            DB::raw("sum(1) as cnt"),
            DB::raw("sum(if (sor = 'Y', 1, 0)) as sor_cnt")
        )
            ->where('mshp_version_id', 2)
            ->groupBy('cmr_law_number','effective_date')
            ->orderBy('cmr_law_number')
            ->orderBy('effective_date')
            ->having('sor_cnt','>',0);

        print $query->toSql() . "\n\n";

        $records = $query->get();

        $y = $p = 0;
        foreach ($records AS $rec) {
            $statute_id = Statute::getIdByNumber($rec->cmr_law_number, Jurisdiction::JURISDICTION_MO);

            if ($rec->cnt == $rec->sor_cnt) {
                StatuteException::create([
                    'statute_id' => $statute_id,
                    'exception_id' => $exception->id,
                    'source' => 'Charge Code Manule 2021-2022 SOR Field',
                    'exception_code_id' => ExceptionCodes::APPLIES
                ]);

            } else {
                StatuteException::create([
                    'statute_id' => $statute_id,
                    'exception_id' => $exception->id,
                    'source' => 'Charge Code Manule 2021-2022 SOR Field',
                    'exception_code_id' => ExceptionCodes::POSSIBLY_APPLIES,
                    'attorney_note' => 'To determine if this is expungable or not use Charge code or research using the conviction Date and Level',
                    'dyi_note' => 'Use the Charge Code of the conviction to determine elegibility',
                ]);
            }
        }

    }
}
