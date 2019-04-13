<?php
/**
 * Created by PhpStorm.
 * User: paulb
 * Date: 2019-04-05
 * Time: 23:42
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{

    public function me() {
        $user = Auth::user();
        unset($user['password']);
        $user['username'] = $user['name'];
        unset($user['name']);
        $payload = [
            'status' => 'success',
            'data' => $user
        ];

        return json_encode($payload);

    }

}
