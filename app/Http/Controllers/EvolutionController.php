<?php

namespace App\Http\Controllers;

use App\Entities\Evolution;
use App\Entities\Appointment;
use Illuminate\Http\Request;

class EvolutionController extends Controller
{
    public function index($appointment)
    {
        return Evolution::where(['appointment_id' => $appointment])->with(['question', 'option'])->get();
    }
}
