<?php

namespace App\Http\Controllers;

use App\Entities\Pathology;
use App\Http\Requests\TypeAheadRequest;

class PathologyController extends Controller
{
    public function typeahead(TypeAheadRequest $request){
        return Pathology::where('cid', 'like', '%'.$request->get("search_term").'%')
        ->orWhere('label', 'like', '%'.$request->get("search_term").'%')
        ->orderBy('label')->limit(15)->get();
    }
}
