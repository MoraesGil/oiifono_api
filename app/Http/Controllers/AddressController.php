<?php

namespace App\Http\Controllers;
use App\Entities\Address;
use App\Http\Requests\AddressRequest;

class AddressController extends Controller
{
    public function index(AddressRequest $request)
    {
        return response()->json(Address::paginate($request->get("limit")?:15), 200);
    }

    public function store(AddressRequest $request)
    {
        return response()->json(Address::create($request->all()), 201);
    }

    public function show($id)
    {
        return Address::findOrFail($id);
    }

    public function update(AddressRequest $request, $id)
    {
        return response()->json(Address::findOrFail($id)->update($request->all()), 200);
    }

    public function destroy($id)
    {
        return response()->json(Address::findOrFail($id)->delete(), 204);
    }
}
