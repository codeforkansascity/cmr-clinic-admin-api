<?php
/**
 * Created by PhpStorm.
 * User: paulb
 * Date: 2019-10-04
 * Time: 23:00.
 */

namespace App\Lib;

use App\Applicant;
use App\Charge;
use App\Conviction;
use App\DataSource;
use App\Statute;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class AddApplicantFromCriminalHistory
{
    public $warnings = [];
    public $errors = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function addHistory()
    {


        $data = $this->data;

        if (!(array_key_exists('name', $data) && !empty($data['name']))) {
            $this->errors[] = 'Missing Client Name';
        }
        if (!(array_key_exists('cms_client_number', $data) && !empty($data['cms_client_number']))) {
            $this->errors[] = 'Missing CMS Client ID';
        } else {
            if (Applicant::select('id')->where('cms_client_number', intval($data['cms_client_number']))->first()) {
                $this->errors[] = 'CMS Client ID ' . intval($data['cms_client_number']) . ' already exists';
            }
        }
        if (!(array_key_exists('cms_matter_number', $data) && !empty($data['cms_matter_number']))) {
            $this->errors[] = 'Missing CMS Case ID';
        } else {
            if (Applicant::select('id')->where('cms_matter_number', intval($data['cms_matter_number']))->first()) {
                $this->errors[] = 'CMS Matter/Case ID ' . intval($data['cms_matter_number']) . ' already exists';
            }
        }

        if (empty($this->errors)) {
            DB::beginTransaction();
            $client = $this->addApplicant($data);
            if (empty($this->errors)) {
                DB::commit();
            } else {
                DB::rollBack();
            }
        } else {
            $client = null;
        }

        return ['warnings' => $this->warnings, 'errors' => $this->errors, 'record' => $client];
    }

    private function addApplicant($data)
    {
        try {
            $client = Applicant::create(array_filter($data));
        } catch (Exception $e) {
            info(__METHOD__ . ' line: ' . __LINE__ . ':  ' . $e->getMessage());
            $this->errors[] = 'Cannot add Applicant ' . $data['name'] . ' ' . $e->getMessage();

            return null;
        } catch (QueryException $e) {
            info(__METHOD__ . ' line: ' . __LINE__ . ':  ' . $e->getMessage());
            $this->errors[] = 'Cannot add Applicant ' . $data['name'] . ' ' . $e->getMessage();

            return null;
        }

        if (array_key_exists('CASES', $data) && !empty($data['CASES'])) {
            $this->addCases($data['CASES'], $client->id);
        }

        return $client->toArray();
    }

    private function addCases($cases, $applicant_id)
    {
        foreach ($cases as $case) {
            $case['applicant_id'] = $applicant_id;

            try {
                $conviction = Conviction::create(array_filter($case));
            } catch (Exception $e) {
                info(__METHOD__ . ' line: ' . __LINE__ . ':  ' . $e->getMessage());
                $this->errors[] = 'Cannot add Case ' . $case['case_number'] . ' ' . $e->getMessage();

                return;
            } catch (QueryException $e) {
                info(__METHOD__ . ' line: ' . __LINE__ . ':  ' . $e->getMessage());
                $this->errors[] = 'Cannot add Case ' . $case['case_number'] . ' ' . $e->getMessage();

                return;
            }

            if (array_key_exists('source', $case) && !empty($case['source'])) {
                $this->addSources($conviction, $case['source']);
            }

            if (array_key_exists('CHARGES', $case) && !empty($case['CHARGES'])) {
                $this->addCharge($case['CHARGES'], $conviction->id);
            }
        }
    }

    private function addSources(&$conviction, $sources)
    {
        $source_ids = [];

        $sources = explode(',', $sources);

        foreach ($sources as $source) {
            $source = trim($source);

            $rec = DataSource::select('id')->where('name', $source)->first();

            if (!empty($rec)) {
                $source_ids[] = $rec->id;
            } else {
                $this->warnings[] = "Case source $source was not found";
            }
        }

        if (!empty($source_ids)) {
            $conviction->sources()->sync($source_ids);
        }
    }

    private function addCharge($charges, $conviction_id)
    {
        foreach ($charges as $charge) {

            $charge['conviction_id'] = $conviction_id;
            unset($charge['source']);

            if (array_key_exists('level_text', $charge) && !empty($charge['level_text'])) {
                $row_parts = [];
                if ($charge['level_text'] == 'Local Ordinance') {
                    $charge['conviction_charge_type'] = 'Local Ordinance';
                    $charge['conviction_class_type'] = '';
                } else {
                    if (0 != preg_match('/^([a-zA-Z]*)\s*([a-zA-Z]*)$/', $charge['level_text'], $row_parts)) {
                        info(print_r($row_parts, true));
                        $charge['conviction_charge_type'] = $row_parts[1];
                        $charge['conviction_class_type'] = $row_parts[2];
                    } else {
                        $charge['conviction_charge_type'] = $charge['level_text'];
                        $charge['conviction_class_type'] = '';
                    }
                }
            }

            if (array_key_exists('imported_citation', $charge) && !empty($charge['imported_citation'])) {
                $number = $charge['imported_citation'];
                $statute_id = 0;
                $statute = Statute::where('number', $number)->first();

                if ($statute) {
                    $statute_id = $statute->id;
                } elseif (preg_match('/^\d{3}\.\d{2}$/', $number)) {
                    $number = $number . "0";
                    $statute = Statute::where('number', $number)->first();
                    if ($statute) {
                        $statute_id = $statute->id;
                    }
                }

                $charge['statute_id'] = $statute_id;
            }

            try {
                $rec = Charge::create(array_filter($charge));
            } catch (Exception $e) {
                info(__METHOD__ . ' line: ' . __LINE__ . ':  ' . $e->getMessage());
                $this->errors[] = 'Cannot add Charge ' . $charge['imported_statute'] . ' ' . $e->getMessage();

                return;
            } catch (QueryException $e) {
                info(__METHOD__ . ' line: ' . __LINE__ . ':  ' . $e->getMessage());
                $this->errors[] = 'Cannot add Charge ' . $charge['imported_statute'] . ' ' . $e->getMessage();

                return;
            }
        }
    }
}
