<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
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
            'loca_code' => 'required|string|max:255',
            'loca_name' => 'required|string|max:255',
            'location_type' => [
                'required',
                'string',
                Rule::in(['Branch', 'Exhibition']),
            ],
            'delivery_address' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ];
    }
}
