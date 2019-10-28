<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RoleDescriptionFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->route('role_description')) {  // If ID we must be changing an existing record
            return Auth::user()->can('role_description edit');
        } else {  // If not we must be adding one
            return Auth::user()->can('role_description add');
        }

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $id = $this->route('role_description');

        $rules = [
         //  Ignore duplicate email if it is this record
         //   'email' => 'required|string|email|unique:invites,email,' . $id . '|unique:users|max:191',


            'id' => 'numeric',
            'role_id' => 'nullable|numeric',
            'role_name' => 'nullable|string|max:191',
            'description' => 'nullable|string',
            'sequence' => 'nullable|numeric',
            'roles_that_can_assign' => 'nullable|string|max:255',
            'deleted_at' => 'nullable|string',

        ];

                if ($this->route('role_description')) {  // If ID we must be changing an existing record
                    $rules['name'] = 'required|min:3|nullable|string|max:191|unique:role_descriptions,name,' . $id;
                } else {  // If not we must be adding one
                    $rules['name'] = 'required|min:3|nullable|string|max:191|unique:role_descriptions';
                }

        return $rules;
    }
}


