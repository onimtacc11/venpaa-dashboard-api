<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookTypeRequest extends FormRequest
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
            'bkt_code' => 'required|string|max:255',
            'bkt_name' => 'required|string|max:255',
        ];
    }
}