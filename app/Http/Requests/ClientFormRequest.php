<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ClientFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->route('client')) {  // If ID we must be changing an existing record
            return Auth::user()->can('client update');
        } else {  // If not we must be adding one
            return Auth::user()->can('client add');
        }

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $id = $this->route('client');

        $rules = [
         //  Ignore duplicate email if it is this record
         //   'email' => 'required|string|email|unique:invites,email,' . $id . '|unique:users|max:191',


            'id' => 'numeric',
            'name' => 'nullable|string|max:64',
            'phone' => 'nullable|string|max:64',
            'email' => 'nullable|string|max:225',
            'sex' => 'nullable|string|max:64',
            'race' => 'nullable|string|max:64',
            'dob' => 'nullable|string|max:64',
            'address_line_1' => 'nullable|string|max:64',
            'address_line_2' => 'nullable|string|max:64',
            'city' => 'nullable|string|max:64',
            'state' => 'nullable|string|max:64',
            'zip_code' => 'nullable|string|max:64',
            'license_number' => 'nullable|string|max:64',
            'license_issuing_state' => 'nullable|string|max:64',
            'license_expiration_date' => 'nullable|string|max:64',
            'filing_court' => 'nullable|string|max:64',
            'judicial_circuit_number' => 'nullable|string',
            'count_name' => 'nullable|string|max:64',
            'judge_name' => 'nullable|string',
            'division_name' => 'nullable|string',
            'petitioner_name' => 'nullable|string',
            'division_number' => 'nullable|string',
            'city_name_here' => 'nullable|string',
            'county_name' => 'nullable|string',
            'arresting_county' => 'nullable|string',
            'prosecuting_county' => 'nullable|string',
            'arresting_municipality' => 'nullable|string',
            'other_agencies_name' => 'nullable|string',
            'previous_expungements' => 'nullable|string',
            'notes' => 'nullable|string|max:255',
            'external_ref' => 'nullable|string|max:42',
            'any_pending_cases' => 'nullable|string|max:255',
            'cms_client_number' => 'nullable|string|max:255',
            'cms_matter_number' => 'nullable|string|max:255',
            'assignment_id' => 'nullable|numeric',
            'step_id' => 'nullable|numeric',


        ];


        return $rules;
    }
}


