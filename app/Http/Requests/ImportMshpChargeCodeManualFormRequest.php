<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ImportMshpChargeCodeManualFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->route('import_mshp_charge_code_manual')) {  // If ID we must be changing an existing record
            return Auth::user()->can('import_mshp_charge_code_manual update');
        } else {  // If not we must be adding one
            return Auth::user()->can('import_mshp_charge_code_manual add');
        }

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $id = $this->route('import_mshp_charge_code_manual');

        $rules = [
         //  Ignore duplicate email if it is this record
         //   'email' => 'required|string|email|unique:invites,email,' . $id . '|unique:users|max:191',


            'id' => 'numeric',
            'mshp_version_id' => 'nullable|numeric',
            'cmr_law_number' => 'nullable|string|max:191',
            'cmr_chapter' => 'nullable|string|max:191',
            'cmr_charge_code_seq' => 'nullable|string|max:191',
            'cmr_charge_code_fingerprintable' => 'nullable|string|max:191',
            'cmr_charge_code_effective_year' => 'nullable|string|max:191',
            'cmr_charge_code_ncic_category' => 'nullable|string|max:191',
            'cmr_charge_code_ncic_modifier' => 'nullable|string|max:191',
            'charge_code' => 'nullable|string|max:191',
            'ncic_mod' => 'nullable|string|max:191',
            'state_mod' => 'nullable|string|max:191',
            'description' => 'nullable|string',
            'type_class' => 'nullable|string|max:191',
            'dna' => 'nullable|string|max:191',
            'sor' => 'nullable|string|max:191',
            'roc' => 'nullable|string|max:191',
            'case_type' => 'nullable|string|max:191',
            'effective_date' => 'nullable|date',

        ];


        return $rules;
    }
}


