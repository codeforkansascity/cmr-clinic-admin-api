<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ImportMshpChargeCodeFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->route('import_mshp_charge_code')) {  // If ID we must be changing an existing record
            return Auth::user()->can('import_mshp_charge_code update');
        } else {  // If not we must be adding one
            return Auth::user()->can('import_mshp_charge_code add');
        }

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $id = $this->route('import_mshp_charge_code');

        $rules = [
         //  Ignore duplicate email if it is this record
         //   'email' => 'required|string|email|unique:invites,email,' . $id . '|unique:users|max:191',


            'id' => 'numeric',
            'mshp_version_id' => 'nullable|numeric',
            'cmr_law_number' => 'nullable|string|max:191',
            'cmr_chapter' => 'nullable|string|max:191',
            'legacy_charge_code' => 'nullable|string|max:191',
            'charge_type' => 'nullable|string|max:191',
            'classification' => 'nullable|string|max:191',
            'effective_date' => 'nullable|date',
            'inactive_date' => 'nullable|date',
            'reportable' => 'nullable|string|max:191',
            'short_description' => 'nullable|string|max:191',
            'not_applicable' => 'nullable|string|max:191',
            'attempt' => 'nullable|string|max:191',
            'accessory' => 'nullable|string|max:191',
            'conspiracy' => 'nullable|string|max:191',
            'code_category' => 'nullable|string|max:191',
            'ncic_category' => 'nullable|string|max:191',
            'statute' => 'nullable|string|max:191',
            'long_description' => 'nullable|string',
            'uniform_citation_ind' => 'nullable|string|max:191',
            'rec_of_conviction' => 'nullable|string|max:191',
            'case_type' => 'nullable|string|max:191',
            'charge_code' => 'nullable|string|max:191',
            'dna_at_arrest' => 'nullable|string|max:191',

        ];


        return $rules;
    }
}


