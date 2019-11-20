<?php

namespace App\Http\Controllers;

use App\Entities\Option;
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

            foreach ($request->only('questions') as $questionRequest) {
                $question  = Question::updateOrCreate($questionRequest);

                foreach ($questionRequest->options as $optionRequest) {
                   $option = Option::updateOrCreate($optionRequest);

                   $storeOptions =  function($option) use ($storeOptions, $optionRequest) {
                    foreach ($optionRequest->options as $childOption) {
                        $child = $option->options()->updateOrCreate($childOption);

                        if($childOption->options != null)
                        return $storeOptions($child);
                    }
                };

                   $question->options()->attach($option,['order'=>$questionRequest->order]);
                }

                $protocol->questions()->attach($question, ['order'=>$questionRequest->order, 'group'=>$questionRequest->group]);
            }
            return $protocol;
        });

        return response()->json($protocol, 201);
    }
}
