<?php

namespace App\Http\Controllers;

use App\Entities\HealthPlan;
use App\Http\Requests\TypeAheadRequest;

class HealthPlanController extends Controller
{
    public function typeahead(TypeAheadRequest $request){
        return HealthPlan::where('label', 'like', '%'.$request->get("search_term").'%')->orderBy('label')->limit(15)->get();
    }
}
