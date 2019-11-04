<?php
/**
 * Created by PhpStorm.
 * User: paulb
 * Date: 2019-07-14
 * Time: 12:07
 */

namespace App\Lib;

use App\Client;
use App\Conviction;


class ConvertDateOfCharge
{
    function __construct() {

        print "\nSTART: Conversion of approximate_date_of_charge_text to date_of_charge\n";

        $convictions = Conviction::with('applicant')->get();

        foreach ($convictions AS $conviction) {

            $conviction->date_of_charge = $this->convertDateToMySql($conviction);
            $conviction->save();
        }

        print "\nEND: Conversion of approximate_date_of_charge_text to date_of_charge\n";


    }

    function convertDateToMySql($conviction) {



        $d = $conviction->approximate_date_of_charge_text;
        // 10-25-1981 -> 1970-01-01

        printf("%-30.30s %-20.20s ", $conviction->applicant->name, $conviction->case_number);
        print "$d -> ";

//        if ($d == 'suspended') {
//            print "\n";
//            return null;
//        }
//
//        if ($d == 'Approx. 2010') {
//            print "\n";
//            return null;
//        }

        $mysql_date = $d;

        if ($d) {
            $mysql_date = preg_replace('#(\d{1,2})-(\d{1,2})-(\d{4,4})#', '${3}-${1}-${2}', $mysql_date);
            $mysql_date = date('Y-m-d', strtotime($mysql_date));
            //$mysql_date = preg_replace('#(\d+)/(\d+)/(\d+)#', '${3}-${1}-${2}', $d);

        } else {
            $mysql_date = null;
        }

        print "$mysql_date\n";

        return $mysql_date;
    }
}
