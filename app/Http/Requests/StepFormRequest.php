<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StepFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->route('step')) {  // If ID we must be changing an existing record
            return Auth::user()->can('step update');
        } else {  // If not we must be adding one
            return Auth::user()->can('step add');
        }

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $id = $this->route('step');

        $rules = [
         //  Ignore duplicate email if it is this record
         //   'email' => 'required|string|email|unique:invites,email,' . $id . '|unique:users|max:191',


            'id' => 'numeric',
            'applicant_id' => 'nullable|numeric',
            'status_id' => 'nullable|numeric',
            'deleted_at' => 'nullable|string',

        ];

                if ($this->route('step')) {  // If ID we must be changing an existing record
                    $rules['name'] = 'required|min:3|nullable|string|max:64|unique:steps,name,' . $id;
                } else {  // If not we must be adding one
                    $rules['name'] = 'required|min:3|nullable|string|max:64|unique:steps';
                }

        return $rules;
    }
}


