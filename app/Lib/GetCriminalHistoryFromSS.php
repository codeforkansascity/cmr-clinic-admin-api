<?php
/**
 * Created by PhpStorm.
 * User: paulb
 * Date: 2019-10-04
 * Time: 23:00.
 */

namespace App\Lib;

use App\Imports\PaulImport;
use App\Imports\PersonHistory;
use Excel;
use Exception;

class GetCriminalHistoryFromSS
{
    public $path = '';
    public $file_name = '';
    public $data = [];

    public $spread_sheet_data = null;

    public $current_row_offset = 0;
    public $current_row = [];

    public $applicant_number;

    public $applicant = [];

    public $current_type = 'CLIENT';
    public $in = 'CLIENT';
    public $case_offset = -1;
    public $record = [];
    public $case = [];

    public $labels = [];
    public $label_errors = 0;

    public $label_map = [
        'Full Name' => 'name',
        'Date of Birth' => 'dob',
        'Client ID' => 'cms_client_number',
        'Case ID' => 'cms_matter_number',

        'Case' => 'name',
        'Case Number' => 'case_number',
        'Name on Court Records' => 'record_name',
        'Arresting Agency' => 'arresting_agency',
        'Date of Arrest' => 'arrest_date',
        'Date of Charge' => 'date_of_charge',
        'Date of Disposition' => 'date_of_disposition',
        'County/City' => 'court_city_county',
        'Judge' => 'judge',
        'Release Status' => 'release_status',

        'Statute #' => 'imported_citation',
        'Level' => 'level_text',
        'Sentence' => 'sentence',
        'Release Date' => 'release_date',
        'Source' => 'source',
    ];

    public function __construct($path, $file_name, $data)
    {
        $this->path = $path;
        $this->file_name = $file_name;
        $this->data = $data;
    }

    public function processSpreadSheet()
    {
        $this->readSpreadSheet($this->path.'/'.$this->file_name);

        while ($this->current_row) {

            if ($this->currentRowEmpty()) {
                $this->getNextRow();
                continue;
            }
            if (!($row_type = $this->getRowType($this->current_row))) {  // CASE, CHARGE, false
                list($label, $value) = $this->cleanRow($this->current_row,0);
                $this->applicant[$label] = $value;
                $this->getNextRow();
            } else {

                if ($row_type != 'CASE') {
                    die("ERROR: Missing Case after Applicant information\n");
                }
                if ($cases_in_row = $this->getCasesInRow()) {

                    if ($cases_in_row > 1 ) {
                        $this->processVerticalCases($cases_in_row);
                        $this->processVerticalCaseCharges($cases_in_row);
                    } else {
                        $this->case_offset = -1;
                        $this->applicant['CASES'] = [];
                        while ($this->current_row) {
                            $this->processHorizontalCases();
                        }

                    }
                } else {
                    die("Error no cases in row");
                }


            }

        }

        return $this->applicant;

    }

    public function processVerticalCases($cases_in_row) {
        print __METHOD__ . "\n";

        $this->addCasesToApplicant($cases_in_row);
        $this->getNextRow();

        while($this->current_row && !$this->getRowType($this->current_row)) {
            if (!$this->currentRowEmpty()) {
                $this->processVerticalCasesColumns($cases_in_row);

            }
            $this->getNextRow();
        }

        $this->processVerticalCaseCharges($cases_in_row);
    }

    private function addCasesToApplicant($cases_in_row) {
        $this->applicant['CASES'] = [];
        for ($i = 0; $i < $cases_in_row; $i++) {
            $this->applicant['CASES'][$i] = [];
        }
    }

    private function processVerticalCasesColumns($cases_in_row) {
        for($i = 0; $i < $cases_in_row; $i++) {
            list($label, $value) = $this->cleanRow($this->current_row,$i);
            $this->applicant['CASES'][$i][$this->convertLable($label)] = $value;
        }
    }

    public function processVerticalCaseCharges($cases_in_row) {

        $charge_offset = -1;

        while($this->current_row) {
            if (!$this->currentRowEmpty()  && $charge_offset < 5) {

                $row_type = $this->getRowTypeCharge($this->current_row,$cases_in_row);

                if ($row_type == 'CHARGE') {
                    $charge_offset++;
                }
                $this->processVerticalCaseChargeColumns($charge_offset, $cases_in_row);
            }
            $this->getNextRow();
        }
    }

    private function processVerticalCaseChargeColumns($charge_offset,$cases_in_row) {

        for($i = 0; $i < $cases_in_row; $i++) {
            list($label, $value) = $this->cleanRow($this->current_row,$i);

            if ($label) {

                if (!array_key_exists('CHARGES', $this->applicant['CASES'][$i])) {
                    $this->applicant['CASES'][$i]['CHARGES'] = [];
                }

                if (!array_key_exists($charge_offset, $this->applicant['CASES'][$i]['CHARGES'])) {
                    $this->applicant['CASES'][$i]['CHARGES'][$charge_offset] = [];
                    $this->applicant['CASES'][$i]['CHARGES'][$charge_offset]['imported_statute'] = $value;
                //
                } else {

                    $this->applicant['CASES'][$i]['CHARGES'][$charge_offset][$label] = $value;
                }
            }
        }
    }

    public function processHorizontalCases() {
        print __METHOD__ . "\n";


        $this->getNextRow();
        $this->case_offset++;
        $this->applicant['CASES'][$this->case_offset] = [];

        // Process the case
        while ($this->current_row
            && $this->getRowType($this->current_row) != 'CHARGE') {
            list($label, $value) = $this->cleanRow($this->current_row,0);
            $this->applicant['CASES'][$this->case_offset][$this->convertLable($label)] = $value;
            $this->getNextRow();
        }

        // Add charges to the case

        $charge_offset = 0;

        while ($this->current_row
            && (($row_type = $this->getRowType($this->current_row)) != 'CASE')) {

            if ($row_type == 'CHARGE') {
                print "new charge\n";
                $charge_offset++;
                $this->applicant['CASES'][$this->case_offset]['CHARGES'][$charge_offset] = [];
                list($label, $value) = $this->cleanRow($this->current_row,0);
                $this->applicant['CASES'][$this->case_offset]['CHARGES'][$charge_offset]['imported_statute'] = $value;
            } else {
                list($label, $value) = $this->cleanRow($this->current_row,0);
                if (!empty($label)) {
                    $this->applicant['CASES'][$this->case_offset]['CHARGES'][$charge_offset][$this->convertLable($label)] = $value;
                }
            }

            $this->getNextRow();
        }

    }





    public function OLDprocessSpreadSheet()
    {
        $this->readSpreadSheet($this->path.'/'.$this->file_name);

        $this->current_type = 'CLIENT';
        $this->in = 'CLIENT';
        $this->record = [];
        $this->case = [];
        while ($this->current_row) {


            list($label, $value) = $this->cleanRow($this->current_row,0);

            // This code should be someplace else, but it works here
            if ($label == 'Release Date') {
                $this->case[$this->convertLable($label)] = $value;
            }

            // print "$this->current_row_offset \$this->in=|$this->in| \$row_type=|$row_type| \$label=|$label|=\$value=|$value|\n";


            // If we are starting a CASE or CHARGE
            if ($row_type  = $this->getRowType($this->current_row)) {  // CASE, CHARGE, false
                switch ($this->in) {
                    case 'CLIENT':  // End Client

                        $this->record['CASES'] = [];
                        $this->applicant = $this->record;
                        $this->applicant['CASES'] = [];
                        break;

                    case 'CHARGE':  // End Charge

                        if (! array_key_exists('CHARGES', $this->case)) {
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

    public function convertLable($label)
    {

        //    return $label;

        if (! array_key_exists($label, $this->label_map)) {
            return "ERROR $label";
        }

        return $this->label_map[$label];
    }

    public function cleanRow($row,$offset)
    {

        $label_col = $offset * 2;
        $value_col = $label_col + 1;

        $label = trim($row[$label_col]);
        $value = $row[$value_col] ? trim($row[$value_col]) : '';
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

    public function getRowType(&$row)
    {
        return $this->getType(trim($row[0]));
    }

    public function getRowTypeCharge(&$row,$cases_in_row)
    {

        $type = false;

        for ($i = 0; $i < $cases_in_row; $i++) {
            if($type = $this->getType($this->current_row[$i*2])) {
                break;
            }
        }

        return $type;
    }

    public function getType($label) {
        $row_parts = [];
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

    private function getCasesInRow() {
        $number_of_cases = 0;
        if ($columns = count($this->current_row)) {
            $max_cases = intval($columns / 2);
            for ($i = 0; $i < $max_cases; $i ++) {
                if ($this->getType($this->current_row[$i*2]) == 'CASE'){ // if lable is case
                    $number_of_cases++;
                } else {
                    print "Column " . $i * 2 . " was not a case header\n";
                    return false;
                }

            }
        }

        return $number_of_cases;
    }
    private function currentRowEmpty() {
        if ($this->current_row) {
            foreach ($this->current_row AS $col) {
                if ($col) {
                    return false;
                }
            }
        }
        return true;
    }



    private function getNextRow()
    {
        if ($this->current_row == null) {
            return null;
        }

        $this->current_row_offset++;

        if (array_key_exists($this->current_row_offset, $this->spread_sheet_data)) {
            $this->current_row = $this->spread_sheet_data[$this->current_row_offset];
        } else {
            $this->current_row = false;
        }

        return $this->current_row;
    }

    /**
     * Load the spread sheet into memory $this->spread_sheet_data.
     *
     * @param $spread_sheet_file_name
     * @return bool
     */
    private function readSpreadSheet($spread_sheet_file_name)
    {
        $tmp = Excel::toArray(new PersonHistory, $spread_sheet_file_name);

        if (count($tmp)) {  // We have data

            foreach ($tmp[0] as $row) {
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
