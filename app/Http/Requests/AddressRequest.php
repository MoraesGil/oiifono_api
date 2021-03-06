<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'person_id' => "required|exists:people,id",
            'city_id' => "required|exists:cities,id",
            'address' => "required|max:255",
            'district' => "nullable|max:100",
            'complements' => "nullable|max:100",
            'zipcode' => "nullable|formato_cep",
        ];
    }
}
