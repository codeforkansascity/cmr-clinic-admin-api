<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InviteEditRequest extends FormRequest
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

        $id = $this->route('invite');

        return [

         //   'email' => 'required|unique:members,email,' . $id . ',id|max:255',

            'id' => 'numeric',
            'email' => 'required|string|email|unique:invites,email,' . $id . '|unique:users|max:191',
            'name' => 'required|string|max:191',
            'role' => 'required|string|max:42|not_in:0',
            'token' => 'string|max:16',


        ];
    }
}


