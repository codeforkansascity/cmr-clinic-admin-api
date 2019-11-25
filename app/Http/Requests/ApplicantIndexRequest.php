<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ApplicantIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;  // Authorization is being done in the controler  ApplicantController::index()
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'page' => 'numeric',
            'column' => 'nullable|string',
            'direction' => 'numeric',
            'keyword' => 'string',
            'assignment_id' => 'nullable|numeric',
            'status_id' => 'nullable|numeric',
        ];
    }
}
