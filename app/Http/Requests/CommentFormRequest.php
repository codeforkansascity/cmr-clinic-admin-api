<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CommentFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->route('comment')) {  // If ID we must be changing an existing record
            return Auth::user()->can('comment update');
        } else {  // If not we must be adding one
            return Auth::user()->can('comment add');
        }

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $id = $this->route('comment');

        $rules = [
         //  Ignore duplicate email if it is this record
         //   'email' => 'required|string|email|unique:invites,email,' . $id . '|unique:users|max:191',


            'id' => 'numeric',
            'user_id' => 'nullable|numeric',
            'body' => 'nullable|string|max:600',
            'commentable_type' => 'nullable|string|max:191',
            'commentable_id' => 'nullable|numeric',
            'deleted_at' => 'nullable|string',

        ];


        return $rules;
    }
}


