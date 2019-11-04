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
            'charge' => 'nullable|string|max:255',
            'citation' => 'nullable|string|max:64',
            'conviction_class_type' => 'nullable|string|max:64',
            'conviction_charge_type' => 'nullable|string|max:64',
            'sentence' => 'nullable|string|max:64',
            'convicted_text' => 'nullable|string|max:64',
            'eligible_text' => 'nullable|string|max:64',
            'please_expunge_text' => 'nullable|string|max:64',
            'to_print' => 'nullable|string|max:64',
            'source' => 'nullable|string',
            'notes' => 'nullable|string',
            'convicted' => 'nullable|numeric',
            'eligible' => 'nullable|numeric',
            'please_expunge' => 'nullable|numeric',

        ];


        return $rules;
    }
}


