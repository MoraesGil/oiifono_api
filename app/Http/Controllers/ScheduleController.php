<?php

namespace App\Http\Controllers;

use App\Entities\Schedule;
use App\Entities\Therapy;
use App\Http\Requests\Schedule\AbsenceScheduleRequest;
use App\Http\Requests\Schedule\UpdateScheduleRequest;
use App\Http\Resources\ScheduleCollection;
use App\Services\ScheduleService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Entities\Doctor;
use App\Http\Requests\Schedule\CreateScheduleRequest;
use App\Http\Requests\Schedule\NewScheduleRequest;
use Illuminate\Support\Collection;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {

        $fromDate = new Carbon($request->query('fromDate', '-15 days'));
        $toDate =  new Carbon($request->query('toDate', '60 days'));

        $doctorId = $request->query('doctor_id', null);

        if ($doctorId == null) $doctorId = $request->user()->person_id;

        $schedules = Schedule::getSchedulesFromInterval($doctorId, $fromDate, $toDate);
        return new ScheduleCollection($schedules);
    }

    public function update(UpdateScheduleRequest $request, ScheduleService $scheduler, $id)
    {
        $schedule = Schedule::query()->findOrFail($id);

        $updatedSchedule = $scheduler->updateSchedule(
            $schedule,
            $request->input('start_at'),
            $request->input('end_at')
        );

        if ($updatedSchedule) return response()->json($updatedSchedule, 200);
        return response()->json($this->createConflictedErrorMessage(), 422);
    }

    public function store(NewScheduleRequest $request, ScheduleService $scheduler)
    {
        $schedule = $scheduler->storeSchedule(new Schedule($request->all()));

        if ($schedule) return response()->json($schedule, 200);
        return response()->json($this->createConflictedErrorMessage(), 422);
    }

    public function confirm($id)
    {
        return Schedule::query()->where('id', $id)->update(['confirmed' => true]);
    }

    public function absence(AbsenceScheduleRequest $request, $id)
    {
        $updateResult = Schedule::query()->where('id', $id)->update($request->only('absence_by'));
        return response()->json($updateResult, 201);
    }

    public function bestSchedules(Request $request, ScheduleService $scheduler, $therapyId)
    {
        return $scheduler->getBestSchedules(
            Therapy::findOrFail($therapyId),
            Doctor::findOrFail($request->user()->person_id)
        )->sortKeys()
            ->map(function (Collection $c) {
                /** Sort by start_at if number os weeks is equal */
                return $c->sort(function ($a, $b) {
                    return $a['weeks'] == $b['weeks'] ? strcmp($a['start_at'], $b['start_at']) : ($a['weeks'] - $b['weeks']);
                })->values();
            });
    }

    public function generate(CreateScheduleRequest $request, ScheduleService $scheduler, $therapyId)
    {
        return $scheduler->schedule(
            Therapy::findOrFail($therapyId),
            Doctor::findOrFail($request->user()->person_id),
            collect($request->input('daysOfWeek'))
        );
    }

    protected function createConflictedErrorMessage()
    {
        return [
            'errors' => [
                'start_at' => 'O periodo selecionado gera conflito com outro agendamento!'
            ]
        ];
    }
}
