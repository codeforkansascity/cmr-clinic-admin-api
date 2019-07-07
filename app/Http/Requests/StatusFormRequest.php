<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StatusFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->route('status')) {  // If ID we must be changing an existing record
            return Auth::user()->can('status update');
        } else {  // If not we must be adding one
            return Auth::user()->can('status add');
        }

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $id = $this->route('status');

        $rules = [
         //  Ignore duplicate email if it is this record
         //   'email' => 'required|string|email|unique:invites,email,' . $id . '|unique:users|max:191',


            'id' => 'numeric',
            'alias' => 'nullable|string|max:12',
            'sequence' => 'nullable|numeric',
            'deleted_at' => 'nullable|string',

        ];

                if ($this->route('status')) {  // If ID we must be changing an existing record
                    $rules['name'] = 'required|min:3|nullable|string|max:60|unique:statuses,name,' . $id;
                } else {  // If not we must be adding one
                    $rules['name'] = 'required|min:3|nullable|string|max:60|unique:statuses';
                }

        return $rules;
    }
}


