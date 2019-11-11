<?php

namespace App\Http\Controllers;

use App\Entities\Person;

class PersonController extends Controller
{

    public function typeahead(TypeAheadRequest $request){
        return Person::where('name', 'like', '%'.$request->get("search_term").'%')->orderBy('name')->limit(15)->get();
    }

}
