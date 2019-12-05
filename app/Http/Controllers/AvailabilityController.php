<?php

namespace App\Http\Controllers;

use App\Entities\Availability;
use App\Http\Requests\AvailabilityRequest;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function personsAvailabilities($id)
    {
        return response()->json(Availability::query()->where('person_id', $id)->get(), 200);
    }

    public function store(AvailabilityRequest $request)
    {
        return Availability::query()->create($request->all());
    }

    public function update(AvailabilityRequest $request, $id)
    {
        return Availability::query()->where('id', $id)->update($request->all());
    }

    public function delete($id)
    {
        return Availability::query()->where('id', $id)->delete();
    }
}
