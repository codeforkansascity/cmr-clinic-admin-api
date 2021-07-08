<?php
/**
 * Created by PhpStorm.
 * User: paulb
 * Date: 2019-07-14
 * Time: 12:07.
 */

namespace App\Lib;

use App\Client;
use App\Conviction;

class ConvertTextDates
{
    public function __construct()
    {
        $applicants = Client::all();

        foreach ($applicants as $applicant) {
            $applicant->dob = $this->convertDateToMySql($applicant->dob_text);
            $applicant->license_expiration_date = $this->convertDateToMySql($applicant->license_expiration_date_text);
            $applicant->save();
        }

        $convictions = Conviction::all();

        foreach ($convictions as $conviction) {
            $conviction->release_date = $this->convertDateToMySql($conviction->release_date_text);
            $conviction->save();
        }
    }

    public function convertDateToMySql($d)
    {

        // 10-25-1981 -> 1970-01-01
        echo "$d -> ";

        if ($d == 'suspended') {
            echo "\n";

            return null;
        }

        if ($d == 'Approx. 2010') {
            echo "\n";

            return null;
        }

        $mysql_date = $d;

        if ($d) {
            $mysql_date = preg_replace('#(\d{1,2})-(\d{1,2})-(\d{4,4})#', '${3}-${1}-${2}', $mysql_date);
            $mysql_date = date('Y-m-d', strtotime($mysql_date));
            //$mysql_date = preg_replace('#(\d+)/(\d+)/(\d+)#', '${3}-${1}-${2}', $d);
        } else {
            $mysql_date = null;
        }

        echo "$mysql_date\n";

        return $mysql_date;
    }
}
