<?php

namespace App\Http\Controllers;

use App\Entities\Contact;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function index(ContactRequest $request)
    {
        return response()->json(Contact::paginate($request->get("limit")?:15), 200);
    }

    public function store(ContactRequest $request)
    {
        return response()->json(Contact::create($request->all()), 201);
    }

    public function show($id)
    {
        return Contact::findOrFail($id);
    }

    public function update(ContactRequest $request, $id)
    {
        return response()->json(Contact::findOrFail($id)->update($request->all()), 200);
    }

    public function destroy($id)
    {
        return response()->json(Contact::findOrFail($id)->delete(), 204);
    }
}
