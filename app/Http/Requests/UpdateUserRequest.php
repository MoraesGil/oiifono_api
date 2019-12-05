<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'name' => 'sometimes|string|max:200',
            'nickname' => 'sometimes|nullable|string|max:200',
            'cnpj' => 'sometimes|string|cnpj|max:45',
            'ie' => 'sometimes|nullable|string|max:45',
            'register' => 'sometimes|string|max:6',
            'crfa' => 'sometimes|string|max:6',
            'birth_date' => 'sometimes|nullable|date',
            'cpf' => 'sometimes|nullable|string|cpf',
            'rg' => 'sometimes|nullable|string|max:45',
            'gender' => ['sometimes', 'nullable', Rule::in(PatientRequest::GENDERS)],
            'disabilities' => 'sometimes|nullable|string|max:100'
        ];
    }
}
