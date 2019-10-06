<?php
/**
 * Created by PhpStorm.
 * User: paulb
 * Date: 2019-10-04
 * Time: 23:00
 */

namespace App\Lib;

use Excel;
use Exception;
use App\Imports\PersonHistory;
use App\Imports\UsersImport;

class GetCriminalHistoryFromSS
{

    var $path = '';
    var $file_name = '';
    var $data = [];


    var $spread_sheet_data = null;

    var $current_row_offset = 0;
    var $current_row = [];

    var $client_number;




    public function __construct($path, $file_name, $data)
    {
        $this->path = $path;
        $this->file_name = $file_name;
        $this->data = $data;
    }

    public function processSpreadSheet()
    {

        $this->readSpreadSheet($this->path . '/' . $this->file_name);
        info(print_r($this->spread_sheet_data, true));

    }

    /**
     * Load the spread sheet into memory $this->spread_sheet_data
     *
     * @param $spread_sheet_file_name
     * @return bool
     */
    private function readSpreadSheet($spread_sheet_file_name)
    {

        Excel::import(new UsersImport,$spread_sheet_file_name);

   //     $array = Excel::toArray(new PersonHistory,$spread_sheet_file_name);
//
//        print_r($array);
        print "\nstop\n";
        exit;

        return true;








        $reader = Excel::load($spread_sheet_file_name);

        $number_of_sheets = $reader->getSheetCount();

        $this->sheet = $reader->getSheet(0);

        $this->spread_sheet_data = $this->sheet->toArray();

        if (count($this->spread_sheet_data)) {  // We have data
            $this->current_row = $this->spread_sheet_data[$this->current_row_offset];
        }

        return true;

    }


}
