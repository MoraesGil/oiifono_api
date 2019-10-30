<?php

namespace App\Http\Controllers;
use Traits\Controllers\ApiRestfulTrait;
use Illuminate\Http\Request;
use App\Entities\Person;


class PatientController extends Controller
{
    use ApiRestfulTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }


    public function store(Request $request)
    {


    }
}
