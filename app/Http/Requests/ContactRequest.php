<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
        $rules = [
            'person_id' => "required|exists:people,id",
            'main' => 'required|boolean',
            'description' => 'required|string'
        ];

        if (strpos($this->input('contact', ''), '@') !== false) {
            $rules['description'] .= '|email';
        }

        return $rules;
    }
}
