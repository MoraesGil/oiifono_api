<?php

namespace App\Http\Controllers;

use Traits\Controllers\ApiRestfulTrait;
use Illuminate\Http\Request;
use App\Entities\Company;
use App\Entities\Individual;
use App\Http\Requests\PersonRequest;

class PersonController extends Controller
{
    public function store(PersonRequest $request)
    {
        $isIndividual = $request->get("cpf");
        $data = $request->all();

        DB::transaction(function () use ($data, $isIndividual) {
            return response()->json(
                ($isIndividual ?
                    Individual::create($data) : Company::create($data))->person()->create($data),
                201
            );
        });
    }

    public function update(Request $request, $id)
    {
        $isIndividual = $request->get("cpf");
        $data = $request->all();

        DB::transaction(function () use ($id, $data, $isIndividual) {
            $pes = Person::findOrFail($id)->update($data);
            $pes->{($isIndividual ? "individual" : "company")}()->update($data);
            return response()->json($pes, 200);
        });
    }

    public function addresses(Request $request, $id)
    {
        $addresses = Person::findOrFail($request->get("person_id"))->adresses()->paginate($request->get("limit") ?: 30);
        return response()->json($addresses, 200);
    }
}
