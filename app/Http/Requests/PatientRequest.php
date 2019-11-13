<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PatientRequest extends FormRequest
{

    const MALE = 'm';
    const FEMALE = 'f';
    const GENDERS = [self::MALE,self::FEMALE];
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
            'sex' => ['required',Rule::in(self::GENDERS)],
            'birthdate' => 'required|date|date_format:d-m-Y|before:tomorrow',
            'disabilities','nullable|string|max:100',
            'cpf' => 'nullable|cpf|formato_cpf|unique:individuals',
            'rg'=>'nullable|string|max:45',
        ];
    }
}
