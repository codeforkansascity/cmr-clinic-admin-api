<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LawVersionFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->route('law_version')) {  // If ID we must be changing an existing record
            return Auth::user()->can('law_version update');
        } else {  // If not we must be adding one
            return Auth::user()->can('law_version add');
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('law_version');

        $rules = [
            //  Ignore duplicate email if it is this record
            //   'email' => 'required|string|email|unique:invites,email,' . $id . '|unique:users|max:191',

            'id' => 'numeric',
            'law_id' => 'numeric',
            'based_on_law_version_id' => 'numeric',
            'version_status' => 'numeric',
            'start_date'  => 'date',
            'end_date' => 'nullable',

            'number' => 'nullable|string|max:191',
            'name' => 'required|min:3|nullable|string|max:500',
            'common_name' => 'nullable|string|max:191',
            'jurisdiction_id' => 'nullable|numeric',
            'note' => 'nullable|string',
            'law_eligibility_id' => 'nullable|numeric',
            'blocks_time' => 'nullable|numeric',
            'same_as_id' => 'nullable|numeric',
            'superseded_id' => 'nullable|numeric',
            'superseded_on' => 'nullable|string|max:191',
            'deleted_at' => 'nullable|string',

        ];

//        if ($this->route('law_version')) {  // If ID we must be changing an existing record
//            $rules['name'] = 'required|min:3|nullable|string|max:500|unique:law_versions,name,' . $id;
//        } else {  // If not we must be adding one
//            $rules['name'] = 'required|min:3|nullable|string|max:500|unique:law_versions';
//        }

        return $rules;
    }
}
