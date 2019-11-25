<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ChargeFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->route('charge')) {  // If ID we must be changing an existing record
            return Auth::user()->can('charge update');
        } else {  // If not we must be adding one
            return Auth::user()->can('charge add');
        }

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $id = $this->route('charge');

        $rules = [
         //  Ignore duplicate email if it is this record
         //   'email' => 'required|string|email|unique:invites,email,' . $id . '|unique:users|max:191',


            'id' => 'numeric',
            'conviction_id' => 'nullable|numeric',
//            'statute_id' => 'nullable|numeric|empty_with:imported_statute',
//            'imported_statute' => 'nullable|string|max:255|empty_with:statute_id',
            'statute_id' => 'nullable|numeric',
            'imported_statute' => 'nullable|string|max:255',
            'imported_citation' => 'nullable|string|max:64',
            'conviction_class_type' => 'nullable|string|max:64',
            'conviction_charge_type' => 'nullable|string|max:64',
            'sentence' => 'nullable|string|max:64',
            'to_print' => 'nullable|string|max:64',
            'notes' => 'nullable|string',
            'convicted' => 'nullable|numeric',
            'eligible' => 'nullable|numeric',
            'please_expunge' => 'nullable|numeric',

        ];


        return $rules;
    }

    public function messages()
    {
        return [
            'statute_id.validation.empty_with' => 'Please select one'
        ];
    }
}


