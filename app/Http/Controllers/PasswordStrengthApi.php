<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordStrengthRequest;
use Illuminate\Http\Response;
use ZxcvbnPhp\Zxcvbn;

class PasswordStrengthApi extends Controller
{
    /**
     * Check strength of the password with optional list of words to ignore.
     *
     * See https://github.com/skegel13/vue-password and https://github.com/bjeavons/zxcvbn-php
     *
     * @return Response
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
