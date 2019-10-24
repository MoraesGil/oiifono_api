<?php

namespace App\Http\Controllers;
use Traits\Controllers\ApiRestfulTrait;
use Illuminate\Http\Request;
use App\Entities\Company;
use App\Entities\Individual;

class ActingAreaController extends Controller
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

        $pes =  App\Entities\Person::create(["name" => "gilberto"]);
        $pf =  App\Entities\Individual::create(["person_id" => $pes->id,"birth_date" => "1990-12-24", "cpf" => rand(1, 1000)]);
        $pf->person()->save($pes);
        $pf->person->personable;
        $pat =  App\Entities\Patient::create(["person_id" => $pf->person_id]);

        DB::transaction(function () use ($request) {
            $data = $request->all();
            return response()->json(($request->get("cpf") ? Individual::create($data) : Company::create($data))->person()->create($data), 201);
        });
    }
}
