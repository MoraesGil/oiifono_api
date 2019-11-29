<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProtocolRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
                return [
                    'title' => 'required|max:45',
                    'type' => 'required|numeric',
                    'questions' => 'required|array',
                    'questions.*.label' => 'required|max:45',
                    'questions.*.description' => 'string|nullable|max:255',
                    'questions.*.options' => ['required', 'array'],
                    'questions.*.options.*' => [new \App\Rules\Option]
                ];

            default:
                return [];
        }
    }
}
