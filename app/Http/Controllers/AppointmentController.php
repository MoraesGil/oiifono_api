<?php

namespace App\Http\Controllers;

use App\Entities\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function store(AddressRequest $request)
    {
        return response()->json(Appointment::create($request->all()), 201);
    }

    public function destroy($id)
    {
        return response()->json(Appointment::findOrFail($id)->delete(), 204);
    }
}
