<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ZxcvbnPhp\Zxcvbn;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordStrengthRequest;

class PasswordStrengthApi extends Controller
{
    /**
     * Check strength of the password with optional list of words to ignore
     *
     * See https://github.com/skegel13/vue-password and https://github.com/bjeavons/zxcvbn-php
     *
     * @return \Illuminate\Http\Response
     */
    public function calc(PasswordStrengthRequest $request)
    {
        if ($request->password) {
            $zxcvbn = new Zxcvbn();
            $strength = $zxcvbn->passwordStrength(
                $request->password,
                $request->password_user_inputs
            );
            return $strength['score'];
        }
        return 0;

    }
}
