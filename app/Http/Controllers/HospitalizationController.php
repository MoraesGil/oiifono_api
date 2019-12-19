<?php

namespace App\Http\Controllers;

use App\Entities\Person;
use App\Entities\Schedule;
use App\Http\Requests\DischangeRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HospitalizationController extends Controller
{
    public function discharge(DischangeRequest $request, $patient_id)
    {
        DB::transaction(function () use ($request,$patient_id) {
            $hospitalization = Person::findOrFail($patient_id)->activeHospitalization();

            if(!$hospitalization)
            throw new NotFoundHttpException("Person has not active hospitalization.");

            $doctor_id = Auth::user()->person_id;

            $hospitalization->update([
                "discharged_by" => $request->get('reason') ?? "",
                "discharged" => Carbon::now(),
                "discharged_doctor_id" => $doctor_id
            ]);

            Schedule::query()
            ->where('person_id', $patient_id)
            ->where('doctor_id', $doctor_id)
            ->where('start_at', '>=', Carbon::now())
            ->delete();
        });
    }
}
