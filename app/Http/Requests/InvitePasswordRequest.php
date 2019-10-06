<?php

namespace App\Http\Requests;


use App\Invite;
use ZxcvbnPhp\Zxcvbn;
use Illuminate\Foundation\Http\FormRequest;

class InvitePasswordRequest extends FormRequest
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
            'password' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $zxcvbn = new Zxcvbn();
                    $strength = $zxcvbn->passwordStrength($value, ['paul', 'barham', 'paulb@savagesoft.com', 'paulb+box@savagesoft.com']);
                    if (intval($strength['score']) < 3) {
                        $fail($attribute . ' is to weak.');
                    }
                },
            ],
            'confirm_password' => 'string|same:password|min:8|max:191',
            'token' => 'string|max:16',
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
            if ($this->checkPasswordStrength()) {
                $validator->errors()->add('password', 'Password is not strong!');
            }
            if ($this->validEmail()) {
                $validator->errors()->add('email', 'Email does not match invitation!');
            }
        });
    }

    function checkPasswordStrength()
    {

        if (!$invite = Invite::where('token', $this->token)->first()) {

            return true;
        }

        // To check for similarities in new pw in these fields:
        $user_inputs = explode(' ', $invite->name); // First/last name
        $user_inputs[] = $invite->email; // Email
        $user_inputs[] = $invite->role; // Role

        if ($this->password) {
            $zxcvbn = new Zxcvbn();
            $strength = $zxcvbn->passwordStrength($this->password, $user_inputs);
            return $strength['score'] < 3;
        }

        return true;
    }

    /**
     * Email entered must match, case-insensitive, the one in the invite.
     * @return bool
     */
    function validEmail()
    {

        if (!$invite = Invite::where('token', $this->token)->first()) {
            return true;
        }

        if (strcasecmp($invite->email, $this->email) === 0) {
            return false;
        }

        return true;

    }
}


