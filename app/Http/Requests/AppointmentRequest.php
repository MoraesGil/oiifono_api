<?php

namespace App\Http\Requests;

use App\Rules\AppointmentEvolution;
use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
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
                    'doctor_id' => 'required|exists:doctors,person_id',
                    'person_id' => 'required|exists:individuals',
                    'overview' => 'required|max:255',
                    'health_plan_id' => 'nullable|exists:health_plans,id',
                    'schedule_id' => 'nullable|exists:schedules,id',
                    'protocol_id' => 'nullable|exists:protocols,id',
                    'evolutions' => 'array',
                    'evolutions.*.question_id' => 'required_unless:protocol_id,null',
                    'evolutions.*.option_id' => 'required_unless:protocol_id,null',
                    'evolutions.*.answer' => 'nullable|max:255',
                    'evolutions.*' => [new AppointmentEvolution($this->input('protocol_id'))],
                    'objectives' => 'array|distinct',
                    'objectives.*.id' => 'required|exists:objectives,id',
                    'objectives.*.therapy_id' => 'required|exists:objectives',
                ];
        }
        return [];
    }
}
