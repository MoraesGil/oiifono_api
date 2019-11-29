<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TherapyRequest extends FormRequest
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
                    'person_id' => 'required|numeric|exists:individuals',
                    'doctor_id' => 'required|numeric|exists:doctors,person_id',
                    'description' => 'required|string',
                    'objectives' => 'sometimes|array',
                    'objectives.*.pathology' => 'required|numeric|exists:pathologies,id',
                    'objectives.*.strategy' => 'required|string',
                    'objectives.*.repeat' => 'required|numeric|min:0',
                    'objectives.*.minutes' => 'required|numeric|min:0'
                ];
            default:
                return [];
        }
    }
}
