<?php
/**
 * Created by PhpStorm.
 * User: paulb
 * Date: 2019-07-14
 * Time: 14:45
 */

namespace App\Lib;

use App\Charge;


class ChargeStatuteToFK
{

    function __construct()
    {
        $charges = Charge::all();

        foreach ($charges AS $charge) {

            if ($charge->statute_id != null) {  // Do not overwrite an existing FK
                continue;
            }

            $number = $charge->imported_citation;
            $statute_id = 0;
            $statute = \App\Statute::where('number', $number)->first();

            if ($statute) {
                $statute_id = $statute->id;
            } else {

                if (!$charge->imported_citation) {      // If we do not have a identifing number force them to look it up
                    continue;
                }

                if (!$charge->imported_statute) {      // If we do not have a identifing description
                    continue;
                }

                if (!preg_match('/^\d\d\d\.\d\d\d$/', $charge->imported_citation)) {  // Make sure citation is in MO  999.999 format
                    continue;
                }

                // Make sure we do not end up with any duplicate names in the statute list
                $existing = \App\Statute::select('id','number', 'name')->whereRaw("LOWER('name')", strtolower($charge->imported_statute))->get();

                info("count=".$existing->count(). " " . $charge->imported_citation . " -- " . strtolower($charge->imported_statute));


                if ($existing->count() > 0) {

                    info(print_r($existing->toArray(),true));
                    continue;
                }

                $statute = new \App\Statute;
                try {

                    $statute->add(
                        [
                            'number' => $charge->imported_citation,
                            'name' => $charge->imported_statute,
                            'note' => '',
                            'statutes_eligibility_id' => \App\Statute::UNDETERMINED
                        ]
                    );
                } catch (\Exception $e) {
                    print(__METHOD__ . ' line: ' . __LINE__ . ':  ' . $e->getMessage());
                    continue;
                } catch (\Illuminate\Database\QueryException $e) {
                    print (__METHOD__ . ' line: ' . __LINE__ . ':  ' . $e->getMessage());
                    continue;
                }

                $statute_id = $statute->id;

            }

            $charge->statute_id = $statute_id;
            $charge->save();
        }

        $charges = Charge::where('conviction_charge_type', 'felony')->get();

        foreach ($charges AS $charge) {
            $charge->conviction_charge_type = 'Felony';
            $charge->save();
        }
    }

}
