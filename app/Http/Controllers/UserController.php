<?php
/**
 * Created by PhpStorm.
 * User: paulb
 * Date: 2019-04-05
 * Time: 23:42
 */

namespace App\Http\Controllers;

use App\User;
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

    /**
     * Returns "options" for HTML select
     * @return array
     */
    public function assignee_options() {
        if (!Auth::user()->can('user index')) {
            return response()->json([
                'error' => 'Not authorized'
            ], 403);
        }

        $data =  User::getAssigneeOptions();

        $data = [ (object)['id' => '-1', 'name' => 'All Assigned'], (object)['id' => '0', 'name' => 'Unassigned'] ] + $data->toArray();

        return $data;
    }



}
