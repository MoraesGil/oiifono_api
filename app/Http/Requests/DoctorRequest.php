<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorRequest extends FormRequest
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
            'name' => 'required|string|max:200',
            'cpf' => 'required|cpf|formato_cpf|unique:individuals',
            'register' => 'required|string|max:30|unique:doctors',
            // 'birthdate' => 'required|date_format:d-m-Y|before:18 years ago',
        ];
    }
}
