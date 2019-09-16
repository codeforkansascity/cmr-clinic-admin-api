<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StatuteFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->route('statute')) {  // If ID we must be changing an existing record
            return Auth::user()->can('statute update');
        } else {  // If not we must be adding one
            return Auth::user()->can('statute add');
        }

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $id = $this->route('statute');

        $rules = [
         //  Ignore duplicate email if it is this record
         //   'email' => 'required|string|email|unique:invites,email,' . $id . '|unique:users|max:191',


            'id' => 'numeric',
            'number' => 'nullable|string|max:191',
            'note' => 'nullable|string',
            'statutes_eligibility_id' => 'nullable|string|max:191',
            'deleted_at' => 'nullable|string',

        ];

                if ($this->route('statute')) {  // If ID we must be changing an existing record
                    $rules['name'] = 'required|min:3|nullable|string|max:500|unique:statutes,name,' . $id;
                } else {  // If not we must be adding one
                    $rules['name'] = 'required|min:3|nullable|string|max:500|unique:statutes';
                }

        return $rules;
    }
}


