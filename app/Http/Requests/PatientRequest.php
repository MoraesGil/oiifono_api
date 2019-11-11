<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
{

    const MALE = 'm';
    const FEMALE = 'f';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
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
            'sex' => 'required|in:'.self::MALE.','.self::FEMALE,
            'birthdate' => 'required|date|date_format:d-m-Y|before:tomorrow',
            'cpf' => 'nullable|cpf|formato_cpf|unique:individuals',
            'rg'=>'nullable|string|max:45',
            'disabilities','nullable|string|max:100'
        ];
    }
}
