<?php

namespace App\Http\Controllers;

use App\Entities\Protocol;
use App\Entities\Question;
use App\Http\Requests\ProtocolRequest;
use App\Http\Requests\TypeAheadRequest;

class ProtocolController extends Controller
{
    public function typeahead(TypeAheadRequest $request){
        return Protocol::where('label', 'like', '%'.$request->get("search_term").'%')->orderBy('label')->limit(15)->get();
    }

    public function store(ProtocolRequest $request)
    {
        $protocol = DB::transaction(function () use ($request) {
            $protocol = Protocol::create($request->only(['type', 'title']));

            foreach ($request->only('questions') as $key => $question) {
                Question::updateOrCreate(['id'=>''],$question);
                $protocol->questions()->append($question, ['order'=>$key]);
            }
            return $protocol;
        });

        return response()->json($protocol, 201);
    }
}
