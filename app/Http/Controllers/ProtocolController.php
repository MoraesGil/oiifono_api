<?php

namespace App\Http\Controllers;

use App\Entities\Protocol;
use App\Http\Requests\TypeAheadRequest;

class ProtocolController extends Controller
{
    public function typeahead(TypeAheadRequest $request){
        return Protocol::where('label', 'like', '%'.$request->get("search_term").'%')->orderBy('label')->limit(15)->get();
    }
}
