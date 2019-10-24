<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Entities\Person;


class DoctorController extends Controller
{

    public function update(Request $request, $id)
    {
        $data = $request->all();
        DB::transaction(function () use ($id,$data) {
            $pes = Person::findOrFail($id)->doctor()->createOrUpdate($data);
            return response()->json($pes, 200);
        });
    }
}
