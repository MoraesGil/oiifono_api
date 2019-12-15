<?php

namespace App\Http\Controllers;

use App\Entities\Person;
use App\Entities\Therapy;
use App\Http\Requests\PatientRequest;
use App\Http\Requests\TypeAheadRequest;
use App\Http\Resources\Patient;
use App\Http\Resources\PatientCollection;
use App\Http\Resources\TherapyResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{

    public function typeahead(TypeAheadRequest $request)
    {
        return Person::patients()->where('name', 'like', '%' . $request->get("search_term") . '%')->orderBy('name')->limit(15)->get();
    }

    public function index(Request $request)
    {
        return response()->json(
            new PatientCollection(Person::patients()->with('individual')->paginate($request->get("limit") ?: 15)),
            200
        );
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
        return response()->json(
            new Patient(Person::with(['individual', 'relatives', 'addresses', 'contacts'])->findOrFail($id))
        );
    }

    public function activeTherapy($patient_id)
    {
        return new TherapyResource (Therapy::showActive($patient_id));
    }

    public function update(PatientRequest $request, $id)
    {
        $pes = DB::transaction(function () use ($request, $id) {
            $pes =  Person::findOrFail($id)->update($request->all());
            $pes->individual = $pes->individual()->update($request->all());
            return $pes;
        });

        return response()->json($pes, 200);
    }
}
