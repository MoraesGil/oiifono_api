<?php

namespace App\Http\Requests\Schedule;

use Illuminate\Foundation\Http\FormRequest;

class NewScheduleRequest extends FormRequest
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
            'person_id' => 'required|numeric|exists:individuals,person_id',
            'doctor_id' => 'required|numeric|exists:doctors,person_id',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at'
        ];
    }
    public function attributes()
    {
        return [
            'start_at' => 'inicio',
            'end_at' => 'termino'
        ];
    }
}
