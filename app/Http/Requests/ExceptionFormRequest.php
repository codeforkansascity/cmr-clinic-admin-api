<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ExceptionFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->route('exception')) {  // If ID we must be changing an existing record
            return Auth::user()->can('exception update');
        } else {  // If not we must be adding one
            return Auth::user()->can('exception add');
        }

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $id = $this->route('exception');

        $rules = [
         //  Ignore duplicate email if it is this record
         //   'email' => 'required|string|email|unique:invites,email,' . $id . '|unique:users|max:191',


            'id' => 'numeric',
            'section' => 'nullable|string|max:191',
            'short_name' => 'nullable|string|max:191',
            'attorney_note' => 'nullable|string',
            'dyi_note' => 'nullable|string',
            'logic' => 'nullable|string|max:191',
            'sequence' => 'nullable|numeric',
            'deleted_at' => 'nullable|string',

        ];

                if ($this->route('exception')) {  // If ID we must be changing an existing record
                    $rules['name'] = 'required|min:3|nullable|string|max:191|unique:exceptions,name,' . $id;
                } else {  // If not we must be adding one
                    $rules['name'] = 'required|min:3|nullable|string|max:191|unique:exceptions';
                }

        return $rules;
    }
}


