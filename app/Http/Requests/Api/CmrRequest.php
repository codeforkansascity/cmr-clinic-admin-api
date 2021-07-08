<?php

namespace App\Http\Requests\Api;

class CmrRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;  // Authorization is being done in the controler  ChargeController::index()
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'statute_number' => 'required|string|exists:statutes,number',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'statute_number.required' => 'A statute number is required.',
            'statute_number.string' => 'Invalide characters in the statute number.',
            'statute_number.exists' => 'Statute number was not found.',
        ];
    }
}
