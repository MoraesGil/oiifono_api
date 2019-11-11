<?php

namespace App\Http\Controllers;

use App\Entities\Strategy;
use App\Http\Requests\TypeAheadRequest;

class StrategyController extends Controller
{
    public function typeahead(TypeAheadRequest $request){
        return Strategy::where('label', 'like', '%'.$request->get("search_term").'%')->orderBy('label')->limit(15)->get();
    }
}
