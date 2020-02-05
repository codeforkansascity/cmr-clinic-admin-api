<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StatuteFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->route('statute')) {  // If ID we must be changing an existing record
            return Auth::user()->can('statute update');
        } else {  // If not we must be adding one
            return Auth::user()->can('statute add');
        }

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $id = $this->route('statute');

        $rules = [
            //  Ignore duplicate email if it is this record
            //   'email' => 'required|string|email|unique:invites,email,' . $id . '|unique:users|max:191',

            'id' => 'numeric',
            'number' => 'nullable|string|max:191',
            'name' => 'nullable|string|max:500',
            'note' => 'nullable|string',
            'statutes_eligibility_id' => 'required|numeric',
            'superseded_id' => 'nullable|numeric',
            'superseded_on' => 'nullable|string',
            'deleted_at' => 'nullable|string',

        ];

        // -----------------------------------------------------------------------
        // A statute is unique based off of the jurisdiction_id, number, and name
        // -----------------------------------------------------------------------

        $d = $this->validationData();

        $number = $d['number'];
        $name = $d['name'];

        // [PDB] We should not need to do this but for some reason jurisdiction_id is notbeing passed by StatuteForm.vue
        if (array_key_exists('jurisdiction_id', $d)) {
            $jurisdiction_id = intval($d['jurisdiction_id']);
        } elseif (array_key_exists('jurisdiction', $d)) {
            $jurisdiction_id = intval($d['jurisdiction']['id']);
        } else {
            $jurisdiction_id = 0;
        }

        if ($this->route('statute')) {  // If ID we must be changing an existing record
            $rules['name'] = [
                'required',
                Rule::unique('statutes')->where(function ($query) use ($number, $name, $jurisdiction_id, $id) {
                    return $query->where('number', $number)
                        ->where('name', $name)
                        ->where('jurisdiction_id', $jurisdiction_id);

                })->ignore($id)
            ];
        } else {  // If not we must be adding one
            $rules['name'] = [
                'required',
                Rule::unique('statutes')->where(function ($query) use ($number, $name, $jurisdiction_id) {
                    return $query->where('number', $number)
                        ->where('name', $name)
                        ->where('jurisdiction_id', $jurisdiction_id);
                }),
            ];
        }

        return $rules;
    }
}


