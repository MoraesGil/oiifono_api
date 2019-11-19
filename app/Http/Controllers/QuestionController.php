<?php

namespace App\Http\Controllers;

use App\Entities\Question;
use App\Http\Requests\TypeAheadRequest;

class QuestionController extends Controller
{
    public function typeahead(TypeAheadRequest $request){
        return Question::where('label', 'like', '%'.$request->get("search_term").'%')->orderBy('label')->limit(15)->get();
    }

}
