<?php
/**
 * Created by PhpStorm.
 * User: paulb
 * Date: 2019-07-14
 * Time: 14:45
 */

namespace App\Lib;

use App\Charge;


class SetYesNoLib
{

    function __construct() {
        $charges = Charge::all();

        foreach ($charges AS $charge) {
            $charge->convicted = $this->convertBoolean($charge->convicted_text);
            $charge->eligible = $this->convertBoolean($charge->eligible_text);
            $charge->please_expunge = $this->convertBoolean($charge->please_expunge_text);
            $charge->save();
        }
    }

    function convertBoolean($val) {
        switch ($val) {
            case "1":
                $val = true;
                break;

            case "0":
                $val = false;
                break;

            default:
                $val = null;
                break;
        }

        return $val;

    }

}
