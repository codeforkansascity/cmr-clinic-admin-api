<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ServiceFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->route('service')) {  // If ID we must be changing an existing record
            return Auth::user()->can('service update');
        } else {  // If not we must be adding one
            return Auth::user()->can('service add');
        }

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $id = $this->route('service');

        $rules = [
         //  Ignore duplicate email if it is this record
         //   'email' => 'required|string|email|unique:invites,email,' . $id . '|unique:users|max:191',


            'id' => 'numeric',
            'address' => 'nullable|string|max:191',
            'address_line_2' => 'nullable|string|max:64',
            'city' => 'nullable|string|max:64',
            'state' => 'nullable|string|max:64',
            'zip' => 'nullable|string|max:64',
            'county' => 'nullable|string|max:64',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|string|max:191',
            'note' => 'nullable|string|max:600',
            'service_type_id' => 'nullable|numeric',
            'deleted_at' => 'nullable|string',

        ];

                if ($this->route('service')) {  // If ID we must be changing an existing record
                    $rules['name'] = 'required|min:3|nullable|string|max:191|unique:services,name,' . $id;
                } else {  // If not we must be adding one
                    $rules['name'] = 'required|min:3|nullable|string|max:191|unique:services';
                }

        return $rules;
    }
}


