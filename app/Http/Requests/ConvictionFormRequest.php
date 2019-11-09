<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ConvictionFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->route('conviction')) {  // If ID we must be changing an existing record
            return Auth::user()->can('conviction update');
        } else {  // If not we must be adding one
            return Auth::user()->can('conviction add');
        }

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $id = $this->route('conviction');

        $rules = [
         //  Ignore duplicate email if it is this record
         //   'email' => 'required|string|email|unique:invites,email,' . $id . '|unique:users|max:191',


            'id' => 'numeric',
            'name' => 'nullable|string|max:64',
            'applicant_id' => 'nullable|numeric',
            'arrest_date' => 'nullable|string|max:64',
            'case_number' => 'required|min:3|string|max:64',
            'agency' => 'nullable|string|max:64',
            'court_name' => 'nullable|string|max:64',
            'court_city_county' => 'nullable|string|max:64',
            'judge' => 'nullable|string|max:64',
            'record_name' => 'nullable|string|max:64',
            'release_status' => 'nullable|string|max:64',
            'release_date_text' => 'nullable|string|max:64',
            'notes' => 'nullable|string',
            'date_of_charge' => 'nullable|date',
            'release_date' => 'nullable|date',

        ];

//                if ($this->route('conviction')) {  // If ID we must be changing an existing record
//                    $rules['name'] = 'required|min:3|nullable|string|max:64|unique:convictions,name,' . $id;
//                } else {  // If not we must be adding one
//                    $rules['name'] = 'required|min:3|nullable|string|max:64|unique:convictions';
//                }

        return $rules;
    }
}


