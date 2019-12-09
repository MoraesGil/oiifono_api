<?php

namespace App\Http\Controllers\Reports;

use App\Entities\Appointment;
use App\Entities\Individual;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PatientAppointmentsReportController extends Controller
{
    public function index(Request $request, $person_id)
    {
        $patient = Individual::query()->with('person')->findOrFail($person_id);
        $objectives = $request->query->getBoolean('objectives');

        $appointments = Appointment::query()
            ->whereHas('hospitalization', function (Builder $query) use ($person_id) {
                $query->where('person_id', $person_id);
            })
            ->with($objectives ? ['doctor'] : ['doctor', 'objectives', 'objectives.strategy'])->get();

        return view('reports.patient-appointments', compact('patient', 'appointments', 'objectives'));
    }
}
