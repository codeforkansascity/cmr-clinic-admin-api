<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use ZxcvbnPhp\Zxcvbn;

class UserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->route('user')) {  // If ID we must be changing an existing record
            return Auth::user()->can('user edit');
        } else {  // If not we must be adding one
            return Auth::user()->can('user add');
        }

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $id = $this->route('user');

        $rules = [
         //  Ignore duplicate email if it is this record
         //   'email' => 'required|string|email|unique:invites,email,' . $id . '|unique:users|max:191',


            'id' => 'numeric',
            //'email' => 'required|string|max:191|unique:users',
            'active' => 'nullable|boolean',
            'email_verified_at' => 'nullable|string',
            'remember_token' => 'nullable|string|max:100',

        ];

                if ($this->route('user')) {  // If ID we must be changing an existing record
                    $rules['name'] = 'required|min:3|string|max:191|unique:users,name,' . $id;
                    $rules['email'] = 'required|min:3|string|max:191|unique:users,email,' . $id;
                    $rules['password'] = 'nullable|string|min:8|max:191';
                    $rules['confirm_password'] = 'nullable|string|min:8|max:191|required_with:password|same:password';
                } else {  // If not we must be adding one
                    $rules['name'] = 'required|min:3|string|max:191|unique:users';
                    $rules['email'] = 'required|min:3|string|max:191|unique:users';
                    $rules['password'] = 'required|string|min:8|max:191';
                    $rules['confirm_password'] = 'required|string|min:8|max:191|same:password|';
                }

        return $rules;
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        if(!empty($this->input('password'))) {
            $validator->after(function ($validator) {
                if ($this->checkPasswordStrength()) {
                    $validator->errors()->add('password', 'Password is not strong!');
                }
            });
        }
    }

    function checkPasswordStrength()
    {
        // To check for similarities in new pw in these fields:
        $user_inputs = [
            $this->input('email') // Email
        ];
        $names = explode(' ', $this->input('name'));
        $user_inputs = array_merge( $user_inputs, $names); // First/last name
        $role_names = [];
        foreach($this->input('selected_roles') as $role) {
            $role_pieces = explode('-', $role);
            foreach($role_pieces as $piece) {
                $role_names[] = $piece;
            }
        }
        $user_inputs = array_merge( $user_inputs, $role_names); // Role name(s)

        if ($this->password) {
            $zxcvbn = new Zxcvbn();
            $strength = $zxcvbn->passwordStrength($this->password, $user_inputs);

            /* Do we need to enforce not setting the same pw twice in a row?
            If so, would probably need to be done here to see if both hashed values
            are the same, since we don't know the plaintext of the current pw
            if(!empty($this->input('id'))) {
                $form_user = \App\User::find($this->input('id'));
                if($form_user) {
                    $user_inputs[] = $form_user->password;
            }
            */

            return $strength['score'] < 3;
        } else {
            return true;
        }
    }
}


