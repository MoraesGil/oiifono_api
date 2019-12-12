<?php

namespace App\Http\Controllers;

use App\Entities\Hospitalization;
use App\Entities\Objective;
use App\Entities\Strategy;
use App\Entities\Therapy;
use App\Http\Requests\TherapyRequest;
use App\Http\Resources\TherapyResource;
use Illuminate\Support\Facades\DB;

class TherapyController extends Controller
{
    public function store(TherapyRequest $request)
    {
        $therapy = DB::transaction(function () use ($request) {
            $hospitalization = Hospitalization::activeHospitalization($request->input('person_id'));

            $therapy = $hospitalization->therapies()
                ->create($request->only(['doctor_id', 'description', 'times_week', 'max_minutes']));

            $therapy->objectives()->saveMany(
                $this->createObjectives($request->input('objectives'))
            );

            return $therapy;
        });

        return $therapy;
    }

    public function show($id)
    {
        return new TherapyResource(
            Therapy::query()->with([
                'objectives',
                'objectives.strategy',
                'objectives.pathology',
                'objectives.appointments:id'
            ])->findOrFail($id)
        );
    }

    protected function createObjectives($objetives)
    {
        $newObjetives = [];
        foreach ($objetives as $objective) {
            $stategy = Strategy::updateOrCreate([
                'label' => $objective['strategy']
            ]);

            $newObjetives[] = new Objective([
                'pathology_id' => $objective['pathology'],
                'strategy_id' => $stategy->id,
                'repeat' => $objective['repeat'],
                'minutes' => $objective['minutes'],
                'description' => $objective['description'],
            ]);
        }
        return $newObjetives;
    }
}
