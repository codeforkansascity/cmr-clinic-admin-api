<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CaseServiceCreateRequest extends FormRequest
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
            'name' => 'required|max:191',
            'service.address' => 'max:191',
            'service.address_line_2' => 'max:64',
            'service.city' => 'max:64',
            'service.state' => 'max:24',
            'service.zip' => 'max:15',
            'service.phone' => 'max:20',
            'service.email' => 'nullable|email',
            'service.note' => 'max:600',
            'service.service_type_id' => 'required|exists:service_types,id',
        ];
    }
}
