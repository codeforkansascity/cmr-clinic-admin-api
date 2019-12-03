<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class JurisdictionFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->route('jurisdiction')) {  // If ID we must be changing an existing record
            return Auth::user()->can('jurisdiction update');
        } else {  // If not we must be adding one
            return Auth::user()->can('jurisdiction add');
        }

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $id = $this->route('jurisdiction');

        $rules = [
         //  Ignore duplicate email if it is this record
         //   'email' => 'required|string|email|unique:invites,email,' . $id . '|unique:users|max:191',


            'id' => 'numeric',
            'jurisdiction_type_id' => 'nullable|numeric',
            'url' => 'nullable|string|max:191',
            'deleted_at' => 'nullable|string',

        ];

                if ($this->route('jurisdiction')) {  // If ID we must be changing an existing record
                    $rules['name'] = 'required|min:3|nullable|string|max:191|unique:jurisdictions,name,' . $id;
                } else {  // If not we must be adding one
                    $rules['name'] = 'required|min:3|nullable|string|max:191|unique:jurisdictions';
                }

        return $rules;
    }
}


