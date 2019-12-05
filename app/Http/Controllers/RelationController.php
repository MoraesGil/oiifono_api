<?php

namespace App\Http\Controllers;

use App\Entities\Person;
use App\Http\Requests\RelationRequest;
use Illuminate\Support\Facades\DB;

class RelationController extends Controller
{

    public function store(RelationRequest $request)
    {
        $relative = DB::transaction(function () use ($request) {
            $person = Person::query()->findOrFail($request->input('person_id'));
            $relative = Person::query()->create($request->only('name'));
            $person->relatives()->attach($relative, $request->only('kinship', 'order', 'contact'));
            return $relative;
        });
        return $relative->load('relatives');
    }
}
