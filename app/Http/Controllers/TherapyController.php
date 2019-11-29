<?php

namespace App\Http\Controllers;

use App\Entities\Hospitalization;
use App\Entities\Objective;
use App\Entities\Pathology;
use App\Entities\Strategy;
use App\Entities\Therapy;
use App\Http\Requests\TherapyRequest;
use Illuminate\Http\Request;

class TherapyController extends Controller
{
    public function store(TherapyRequest $request)
    {
        $hospitalization = Hospitalization::activeHospitalization($request->input('person_id'));
        
        $therapy = $hospitalization->therapies()
            ->create($request->only(['doctor_id', 'description']));

        $objectives = $this->createObjectives($request->input('objectives'));

        $therapy->objectives()->saveMany($objectives);

        return $therapy;
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
