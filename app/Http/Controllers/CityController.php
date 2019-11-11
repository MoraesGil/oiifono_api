<?php

namespace App\Http\Controllers;

use App\Entities\City;
use App\Http\Requests\TypeAheadRequest;

class CityController extends Controller
{
    public function typeahead(TypeAheadRequest $request){
        return City::where('name', 'like', '%'.$request->get("search_term").'%')->orderBy('name')->limit(15)->get();
    }
}
