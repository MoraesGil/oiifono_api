<?php

namespace App\Http\Controllers;

use App\Entities\ActingArea;
use App\Http\Requests\ActingAreaRequest;

class ActingAreaController extends Controller
{
    public function index(ActingAreaRequest $request)
    {
        return response()->json(ActingArea::paginate($request->get("limit")?:15), 200);
    }

    public function store(ActingAreaRequest $request)
    {
        return response()->json(ActingArea::create($request->all()), 201);
    }

    public function show($id)
    {
        return ActingArea::findOrFail($id);
    }

    public function update(ActingAreaRequest $request, $id)
    {
        return response()->json(ActingArea::findOrFail($id)->update($request->all()), 200);
    }

    public function destroy($id)
    {
        return response()->json(ActingArea::findOrFail($id)->delete(), 204);
    }
}
