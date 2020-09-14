<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PetitionFieldFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->route('petition_field')) {  // If ID we must be changing an existing record
            return Auth::user()->can('petition_field update');
        } else {  // If not we must be adding one
            return Auth::user()->can('petition_field add');
        }

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $id = $this->route('petition_field');

        $rules = [
            //  Ignore duplicate email if it is this record
            //   'email' => 'required|string|email|unique:invites,email,' . $id . '|unique:users|max:191',


            'id' => 'numeric',
            'applicant_id' => 'nullable|numeric',
            'petition_number' => 'nullable|numeric',
            'name' => 'nullable|string|max:191',
            'value' => 'nullable|string|max:191',

        ];


        return $rules;
    }
}


