<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class ObjectiveRequest extends FormRequest
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
                    'therapy_id' => 'required|numeric|exists:therapies,id',
                    'pathology' => 'required|numeric|exists:pathologies,id',
                    'strategy' => 'required|string',
                    'repeat' => 'required|numeric|min:0',
                    'minutes' => 'required|numeric|min:0'
                ];
            default:
                return [];
        }
    }
}
