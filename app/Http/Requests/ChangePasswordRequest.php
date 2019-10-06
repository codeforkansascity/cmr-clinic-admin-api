<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use ZxcvbnPhp\Zxcvbn;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
        return [
            'current_password' => 'required|string|min:4|max:191',
            'password' => [
                'required',
                'string',
            ],
            'confirm_password' => 'required|string|same:password|min:8|max:191',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->checkCurrentPasswordVerified()) {
                $validator->errors()->add('current_password', 'Current password incorrect.');
            }
            if ($this->checkPasswordStrength()) {
                $validator->errors()->add('password', 'Password is not strong!');
            }
        });
    }

    function checkCurrentPasswordVerified()
    {
        // Verify auth user's current password before resetting password
        $current_user = Auth::user();
        return !password_verify($this->current_password, $current_user->password);
    }

    function checkPasswordStrength()
    {
        // To check for similarities in new pw in these fields:
        $current_user = Auth::user();
        $user_inputs = [
            $this->current_password, // Current pw; has to be from the form so we can compare the unhashed values
            $current_user->email // Email
        ];
        $names = explode(' ', $current_user->name);
        $user_inputs = array_merge( $user_inputs, $names); // First/last name
        $role_names = array_column( $current_user->roles->toArray(), 'name');
        $user_inputs = array_merge( $user_inputs, $role_names); // Role name(s)

        if ($this->password) {
            $zxcvbn = new Zxcvbn();
            $strength = $zxcvbn->passwordStrength($this->password, $user_inputs);
            return $strength['score'] < 3;
        } else {
            return true;
        }
    }
}


