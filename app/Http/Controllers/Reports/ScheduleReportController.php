<?php

namespace App\Http\Controllers\Reports;

use App\Entities\Doctor;
use App\Entities\Schedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class ScheduleReportController extends Controller
{
    public function index(Request $request, $doctor_id)
    {
        $start_at = Carbon::parse($request->input('start_at', 'today'))->startOfDay();
        $end_at = Carbon::parse($request->input('end_at', 'today'))->endOfDay();

        $doctor = Doctor::query()->findOrFail($doctor_id);
        $schedules = Schedule::query()
            ->where('start_at', '>=', $start_at)
            ->where('end_at', '<=', $end_at)
            ->where('doctor_id', $doctor_id)
            ->with(['patient', 'patient.person'])
            ->orderBy('start_at')
            ->get();

        return view('reports.schedule', compact('doctor', 'schedules'));
    }
}
