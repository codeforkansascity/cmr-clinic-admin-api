<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $id = $this->route('role');

        return [

         //   'email' => 'required|unique:members,email,' . $id . ',id|max:255',

                        'name' => 'string|max:64',
                        'alias' => 'string|max:16',
                        'on_master_roster' => 'numeric',
            

        ];
    }
}


