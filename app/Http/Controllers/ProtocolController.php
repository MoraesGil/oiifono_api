<?php

namespace App\Http\Controllers;

use App\Entities\Option;
use App\Entities\Protocol;
use App\Entities\ProtocolQuestion;
use App\Entities\Question;
use App\Http\Requests\ProtocolRequest;
use App\Http\Requests\TypeAheadRequest;
use App\Http\Resources\Protocol as ProtocolResource;
use Illuminate\Support\Facades\DB;

class ProtocolController extends Controller
{
    public function typeahead(TypeAheadRequest $request)
    {
        return Protocol::where('label', 'like', '%' . $request->get("search_term") . '%')->orderBy('label')->limit(15)->get();
    }

    public function show($id)
    {
        return new ProtocolResource(Protocol::with([
            'protocolQuestions',
            'protocolQuestions.question',
            'protocolQuestions.options',
            /**
             *  Optimizes queries for options three levels deep. No extra overhead.
             *  Avoids singular query for each option. Instead, do a query for each level.
             */
            'protocolQuestions.options.options',
            'protocolQuestions.options.options.options',
            'protocolQuestions.options.options.options.options',
        ])->findOrFail($id));
    }

    public function store(ProtocolRequest $request)
    {
        $protocol = DB::transaction(function () use ($request) {
            $protocol = Protocol::create($request->only(['type', 'title']));
            $this->createQuestions($request->input('questions'), $protocol);
            return $protocol;
        });
        return response()->json($protocol, 201);
    }

    protected function createQuestions($questionsData, Protocol $protocol)
    {
        foreach ($questionsData as $index => $questionData) {
            $question = Question::updateOrCreate(['label' => $questionData['label']], ['description' => $questionData['description'] ?? null]);

            $protocolQuestion = ProtocolQuestion::create([
                'protocol_id' => $protocol->id,
                'question_id' => $question->id,
                'order' => $index
            ]);

            $this->createQuestionOptions($questionData['options'], $protocolQuestion);
        }
    }

    protected function createQuestionOptions($optionsData, ProtocolQuestion $protocolQuestion, Option $parentOption = null)
    {
        $parentId = $parentOption ? $parentOption->id : null;
        foreach ($optionsData as $index => $optionData) {
            $option = Option::updateOrCreate([
                'label' => $optionData['label'] ?? "",
                'lines' => $optionData['lines'] ?? 0,
                'parent_id' => $parentId,
            ]);

            $protocolQuestion->options()->attach($option, [
                'order' => $index,
                'group' => $optionData['group'] ?? null
            ]);

            if (isset($optionData['options']))
                $this->createQuestionOptions($optionData['options'], $protocolQuestion, $option);
        }
    }

    protected function getSuboptions(Option $option)
    {
        foreach ($option->options as $option) {
            $this->getSuboptions($option);
        }
    }
}
