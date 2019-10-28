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

    var $applicant_number;


    public function __construct($path, $file_name, $data)
    {
        $this->path = $path;
        $this->file_name = $file_name;
        $this->data = $data;
    }

    public function processSpreadSheet()
    {

        $this->readSpreadSheet($this->path . '/' . $this->file_name);

        $this->in_applicant = true;
        $this->in_case = false;
        $this->in_charge = false;
        $this->current_type = 'CLIENT';
        $this->in = 'CLIENT';
        $this->record = [];
        $this->case = [];
        while ($this->current_row) {


            $label = $this->current_row[0];
            $value = $this->current_row[1] ? $this->current_row[1] : '';

            $row_type = $this->getRowType($this->current_row);

            list($label, $value) = $this->cleanRow($this->current_row);

            if ($row_type) {

                print "\n $row_type |" . $this->in . "|" . $this->current_type . "|\n-----------------------------------\n";
                print_r($this->record);

                switch ($this->in) {
                    case 'CLIENT':
                        print "end applicant\n";
                        $this->record['CASES'] = [];
                        $this->applicant = $this->record;
                        $this->applicant['CASES'] = [];
                        break;

                    case 'CHARGE':
                        print "end charge\n";
                        if (!array_key_exists('CHARGES', $this->case)) {
                            $this->case['CHARGES'] = [];
                        }
                        $this->case['CHARGES'][] = $this->record;

                        if ($row_type == 'CASE') {
                            $this->applicant['CASES'][] = $this->case;
                            $this->case = [];
                        }

                }

                $this->record = [];
                $this->current_type = $row_type;
                $this->in = $row_type;


            }

            switch( $row_type) {

                case 'CHARGE':
                    $this->record['statute_text'] = $value;
                    break;

                default:
                    switch ($this->in) {
                        case 'CASE':
                            $this->case[$label] = $value;
                            break;

                        default:
                            $this->record[$label] = $value;
                            break;
                    }

            }


            $this->getNextRow();
        }

        print $this->current_type . "\n\n-----------------------------------\n";
        print_r($this->record);

        print "\n\n-----------------------------------\n";
        print_r($this->applicant);
        print "END\n";

    }

    function cleanRow($row) {
        $label = trim($row[0]);
        $value = $row[1] ? trim($row[1]) : '';
        if ( 0 != preg_match('/(Case)\s*(\d+)$/',$label, $row_parts)) {
            $label = 'Case';
        }

        if ($value) {
            switch ($label) {
                case 'Date of Arrest':
                case 'Date of Birth':
                case 'Date of Charge':
                case 'Date of Disposition':
                case 'Release Date':
                    $value = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intval($value))->format('m-d-Y');
                    break;
            }
        }

        return [$label, $value];

    }

    function getRowType(&$row) {
        $row_parts = [];
        $label = trim($row[0]);
        if ( 0 != preg_match('/(Case)\s*(\d+)$/',$label, $row_parts)) {
            return 'CASE';
        }
        if ( 0 != preg_match('/(Charge)\s*(\d+)$/',$label, $row_parts)) {
            return 'CHARGE';
        }

        return false;

    }

    private function getNextRow()
    {

        if ($this->current_row == null) return null;

        $this->current_row_offset++;
        if (array_key_exists($this->current_row_offset, $this->spread_sheet_data)) {
            $this->current_row = $this->spread_sheet_data[$this->current_row_offset];
        } else {
            $this->current_row = false;
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
                if (isset($row[0]) && !($row[0] == null && $row[1] == null)) {
                    $this->spread_sheet_data[] = $row;
                }
            }
            if (count($this->spread_sheet_data)) {
                $this->current_row = $this->spread_sheet_data[$this->current_row_offset];
            }

        }

        return true;

    }


}
