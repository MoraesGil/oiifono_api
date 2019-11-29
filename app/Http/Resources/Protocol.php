<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Protocol extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->withoutWrapping();
        return [
            'id' => $this->id,
            'title' => $this->title,
            'type' => $this->type,
            'questions' => new ProtocolQuestionCollection($this->whenLoaded('protocolQuestions'))
        ];
    }
}
