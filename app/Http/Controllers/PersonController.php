<?php

namespace App\Http\Controllers;

use App\Entities\Person;
use App\Http\Requests\RelationRequest;

class PersonController extends Controller
{

    public function typeahead(TypeAheadRequest $request)
    {
        return Person::where('name', 'like', '%' . $request->get("search_term") . '%')->orderBy('name')->limit(15)->get();
    }
}
