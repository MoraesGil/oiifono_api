<?php

namespace App\Http\Controllers;

use App\Entities\Individual;
use App\Entities\Person;
use App\Http\Requests\PatientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{

    public function index(Request $request)
    {
        return response()->json(Individual::With('person')->paginate($request->get("limit")?:15), 200);
    }


    public function store(PatientRequest $request)
    {
        $pes = DB::transaction(function () use ($request) {
            $pes = Person::create($request->all());
            $pes->individual = $pes->individual()->create($request->all());
            return $pes;
        });

        return response()->json($pes, 201);
    }

    public function show($id)
    {
        return Person::with('individual')->findOrFail($id);
    }

    public function update(PatientRequest $request, $id)
    {
        $pes = DB::transaction(function () use ($request,$id) {
            $pes =  Person::findOrFail($id)->update($request->all());
            $pes->individual = $pes->individual()->update($request->all());
            return $pes;
        });

        return response()->json($pes, 200);
    }
}
