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

    var $applicant = [];


    var $current_type = 'CLIENT';
    var $in = 'CLIENT';
    var $record = [];
    var $case = [];

    var $labels = [];
    var $label_errors = 0;

    var $label_map = [
        "Full Name" => "name",
        "Date of Birth" => "dob",
        "Client ID" => "cms_client_number",
        "Case ID" => "cms_matter_number",


        "Case" => "name",
        "Case Number" => "case_number",
        "Name on Court Records" => "record_name",
        "Arresting Agency" => "arresting_agency",
        "Date of Arrest" => "arrest_date",
        "Date of Charge" => "date_of_charge",
        "Date of Disposition" => "date_of_disposition",
        "County/City" => "court_city_county",
        "Judge" => "judge",
        "Release Status" => "release_status",

        "Statute #" => "imported_citation",
        "Level" => "level_text",
        "Sentence" => "sentence",
        "Release Date" => "release_date",
        "Source" => "source",
    ];


    public function __construct($path, $file_name, $data)
    {
        $this->path = $path;
        $this->file_name = $file_name;
        $this->data = $data;
    }

    public function processSpreadSheet()
    {

        $this->readSpreadSheet($this->path . '/' . $this->file_name);

        $this->current_type = 'CLIENT';
        $this->in = 'CLIENT';
        $this->record = [];
        $this->case = [];
        while ($this->current_row) {


            $label = $this->current_row[0];
            $value = $this->current_row[1] ? $this->current_row[1] : '';

            $row_type = $this->getRowType($this->current_row);


            list($label, $value) = $this->cleanRow($this->current_row);

            // This code should be someplace else, but it works here
            if ($label == 'Release Date') {
                $this->case[$this->convertLable($label)] = $value;
            }



            // print "$this->current_row_offset \$this->in=|$this->in| \$row_type=|$row_type| \$label=|$label|=\$value=|$value|\n";

            if ($row_type) {


                switch ($this->in) {
                    case 'CLIENT':

                        $this->record['CASES'] = [];
                        $this->applicant = $this->record;
                        $this->applicant['CASES'] = [];
                        break;

                    case 'CHARGE':

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

            switch ($row_type) {

                case 'CHARGE':
                    $this->record['imported_statute'] = $value;
                    break;

                default:


                    switch ($this->in) {
                        case 'CASE':
                            $this->case[$this->convertLable($label)] = $value;
                            break;

                        default:

                            if ($label == 'Source') {
                                $this->case['Source'] = $value;
                            } else {
                                $this->record[$this->convertLable($label)] = $value;
                            }
                            break;
                    }

            }


            $this->getNextRow();
        }

        // Flush out any straglers

        if (count($this->record)) {
            $this->case['CHARGES'][] = $this->record;
        }

        if (count($this->case)) {
            $this->applicant['CASES'][] = $this->case;
        }


        return $this->applicant;


    }

    function convertLable($label)
    {

        //    return $label;

        if (!array_key_exists($label, $this->label_map)) {
            return "ERROR $label";
        }
        return $this->label_map[$label];
    }

    function cleanRow($row)
    {
        $label = trim($row[0]);
        $value = $row[1] ? trim($row[1]) : '';
        if (0 != preg_match('/(Case)\s*(\d+)$/', $label, $row_parts)) {
            $label = 'Case';
        }

        if ($value) {
            switch ($label) {

                // Date fields that are dates, always convert
                case 'Date of Birth':
                case 'Date of Charge':
                case 'Release Date':
                    if (is_numeric($value)) {
                        $value = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intval($value))->format('Y-m-d');
                    } else {
                        $value = null;
                    }
                    break;

                // Date fields that are string, if numberic we will assume it is a date
                case 'Date of Arrest':
                case 'Date of Disposition':
                    if (is_numeric($value)) {
                        $value = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intval($value))->format('m/d/Y');
                    }
                    break;



            }
        }

        return [$label, $value];

    }

    function getRowType(&$row)
    {
        $row_parts = [];
        $label = trim($row[0]);
        if (0 != preg_match('/^(Case)\s*(\d+)$/', $label, $row_parts)) {
            return 'CASE';
        }
        if (0 != preg_match('/^(Case)$/', $label, $row_parts)) {
            return 'CASE';
        }
        if (0 != preg_match('/^(Charge)\s*(\d+)$/', $label, $row_parts)) {
            return 'CHARGE';
        }
        if (0 != preg_match('/^(Charge)$/', $label, $row_parts)) {
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
                // if (isset($row[0]) && !($row[0] == null && $row[1] == null)) {
                $this->spread_sheet_data[] = $row;
                // }
            }
            if (count($this->spread_sheet_data)) {
                $this->current_row = $this->spread_sheet_data[$this->current_row_offset];
            }

        }

        return true;

    }


}
