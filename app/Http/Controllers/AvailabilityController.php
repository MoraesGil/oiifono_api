<?php

namespace App\Http\Controllers;

use App\Entities\Availability;
use App\Http\Requests\AvailabilityRequest;
use Illuminate\Support\Facades\Auth;

class AvailabilityController extends Controller
{
    public function index()
    {
        return response()->json(Auth::user()->person->availabilities, 200);
    }

    public function store(AvailabilityRequest $request)
    {
        return response()->json(Auth::user()->person->availabilities()->create($request->all()), 201);
    }

    public function destroy($id)
    {
        return response()->json(Availability::findOrFail($id)->delete(), 204);
    }
}
