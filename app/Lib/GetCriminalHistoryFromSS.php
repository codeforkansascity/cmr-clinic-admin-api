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
use App\Imports\PaulImport;

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



    private function getNextRow()
    {

        if ($this->current_row == null) return null;

        $this->current_row_offset++;
        if (array_key_exists($this->current_row_offset, $this->spread_sheet_data)) {
            $this->current_row = $this->spread_sheet_data[$this->current_row_offset];
        } else {
            $this->current_row = null;
        }
        return $this->current_row;
    }

    /**
     * Load the spread sheet into memory $this->spread_sheet_data
     *
     * @param $spread_sheet_file_name
     * @return bool
     */
    private function readSpreadSheet($spread_sheet_file_name)
    {


        $tmp = Excel::toArray(new PersonHistory, $spread_sheet_file_name);



        if (count($tmp)) {  // We have data
            foreach ($tmp[0] AS $row) {
                print_r($row);
                if (isset($row[0]) && isset($row[1]) && !($row[0] == null && $row[1] == null)) {
                    $this->spread_sheet_data[] = $row;
                }
            }
            if (count($this->spread_sheet_data)) {
                $this->current_row = $this->spread_sheet_data[$this->current_row_offset];
            }

        }

        dd($this->current_row);

        return true;

    }


}
