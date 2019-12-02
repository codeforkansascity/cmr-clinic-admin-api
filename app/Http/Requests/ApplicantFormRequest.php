<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ApplicantFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->route('applicant')) {  // If ID we must be changing an existing record
            return Auth::user()->can('applicant update');
        } else {  // If not we must be adding one
            return Auth::user()->can('applicant add');
        }

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $id = $this->route('applicant');

        $rules = [
            //  Ignore duplicate email if it is this record
            //   'email' => 'required|string|email|unique:invites,email,' . $id . '|unique:users|max:191',


            'id' => 'numeric',
            'phone' => 'nullable|string|max:64',
            'email' => 'nullable|string|max:225',
            'sex' => 'nullable|string|max:64',
            'race' => 'nullable|string|max:64',
            'address_line_1' => 'nullable|string|max:64',
            'address_line_2' => 'nullable|string|max:64',
            'city' => 'nullable|string|max:64',
            'state' => 'nullable|string|max:64',
            'zip_code' => 'nullable|string|max:64',
            'license_number' => 'nullable|string|max:64',
            'license_issuing_state' => 'nullable|string|max:64',
            'previous_expungements' => 'nullable|string',
            'previous_felony_expungements' => 'nullable|numeric',
            'previous_misdemeanor_expungements' => 'nullable|numeric',
            'notes' => 'nullable|string|max:255',
            'external_ref' => 'nullable|string|max:42',
            'any_pending_cases' => 'nullable|string|max:255',
            'deleted_at' => 'nullable|string',
            'status_id' => 'nullable|numeric',
            'dob' => 'nullable|date',
            'license_expiration_date' => 'nullable|date',
            'cms_client_number' => 'nullable|string|max:16',
            'cms_matter_number' => 'nullable|string|max:16',
            'assignment_id' => 'nullable|numeric',
            'step_id' => 'nullable|numeric',

        ];

        $rules['name'] = 'required|min:3|nullable|string|max:64';

//        if ($this->route('applicant')) {  // If ID we must be changing an existing record
//            $rules['name'] = 'required|min:3|nullable|string|max:64|unique:applicants,name,' . $id;
//        } else {  // If not we must be adding one
//            $rules['name'] = 'required|min:3|nullable|string|max:64|unique:applicants';
//        }

        return $rules;
    }
}


