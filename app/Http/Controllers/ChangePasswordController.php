<?php

namespace App\Http\Controllers;

use DB;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\Auth;

class ChangePasswordController extends Controller
{
    /**
     * Show the form for changing the current user's own password.
     *
     * @return \Illuminate\Http\Response
     */
    public function changePassword()
    {
        // To check for similarities in new pw in these fields:
        $current_user = Auth::user();
        $user_inputs = [
            $current_user->email // Email
        ];
        $names = explode(' ', $current_user->name);
        $user_inputs = array_merge( $user_inputs, $names); // First/last name
        $role_names = array_column( $current_user->roles->toArray(), 'name');
        $user_inputs = array_merge( $user_inputs, $role_names); // Role name(s)

        return view('change-password.change_password', compact( 'user_inputs'));
    }

    /**
     * Update the user's password in the db.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Invite $invite * @return \Illuminate\Http\Response
     */
    public function updatePassword(ChangePasswordRequest $request)
    {
        $current_user = Auth::user();

        if (!$user = $this->sanitizeAndFind($current_user->id)) {
            //\Session::flash('flash_error_message', 'Unable to find User to edit');
            return response()->json([
                'message' => 'Not Found'
            ], 404);
        }

        $user->password = bcrypt($request->password);

        if ($user->isDirty()) {
            $user->save();
            \Session::flash('flash_success_message', 'Password was changed');
        } else {
            \Session::flash('flash_info_message', 'No changes were made');
        }

        //return Redirect::route('change_password'); // Don't redirect here or we'll lose the session message we just set
        return response()->json([
            'message' => 'Changed record'
        ], 200);
    }

    /**
     * Find by ID, sanitize the ID first
     *
     * @param $id
     * @return User or null
     */
    private function sanitizeAndFind($id)
    {
        return \App\User::find(intval($id));
    }
}
