<?php

namespace App\Http\Controllers;

use App\Entities\Appointment;
use App\Entities\Hospitalization;
use App\Http\Requests\AppointmentRequest;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function store(AppointmentRequest $request)
    {
        $appointment = DB::transaction(function () use ($request) {
            $hospitalizaion = Hospitalization::activeHospitalization($request->input('person_id'));

            $appointment = $hospitalizaion->appointments()->create(
                $request->only(['doctor_id', 'overview', 'health_plan_id', 'schedule_id', 'protocol_id'])
            );

            $appointment->evolutions()->createMany($request->input('evolutions'));
            $appointment->objectives()->attach(
                $this->computeObjectivesAttachStatement($request->input('objectives'))
            );

            return $appointment;
        });

        return $appointment;
    }

    public function destroy($id)
    {
        return response()->json(Appointment::findOrFail($id)->delete(), 204);
    }

    protected function computeObjectivesAttachStatement($objectives)
    {
        $attach  = [];
        foreach ($objectives as $objective) {
            $attach[$objective['id']] = [
                'therapy_id' => $objective['therapy_id']
            ];
        }
        return $attach;
    }
}
