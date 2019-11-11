<?php

namespace App\Http\Controllers;

use App\Entities\Person;
use App\Http\Requests\PatientRequest;

class PatientController extends Controller
{
    public function store(PatientRequest $request)
    {
        DB::transaction(function () use ($request) {
            $pes = Person::create($request->all());
            $pes->individuals()->create($request->all());
        });
    }
}
