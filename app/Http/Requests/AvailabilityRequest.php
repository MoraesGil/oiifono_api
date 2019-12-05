<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AvailabilityRequest extends FormRequest
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
            'person_id' => 'required|numeric|exists:people,id',
            'week_day' => 'required|numeric|between:0,6',
            'start_at' => 'required|date_format:H:i',
            'end_at' => 'required|date_format:H:i',
        ];
    }
}
