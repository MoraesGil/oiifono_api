<?php

namespace App\Http\Controllers;

use App\Entities\Objective;
use App\Entities\Strategy;
use App\Http\Requests\ObjectiveRequest;
use Illuminate\Http\Request;

class ObjectiveController extends Controller
{
    public function store(ObjectiveRequest $request)
    {
        $strategy = Strategy::updateOrCreate(['label' => $request->input('strategy')]);
        $objective = new Objective($request->all());

        $objective->fill([
            'pathology_id' => $request->input('pathology'),
            'strategy_id' => $strategy->id,
        ]);

        $objective->save();
        return $objective;
    }
}
