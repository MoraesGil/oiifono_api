<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProtocolQuestion extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (!$this->relationLoaded('question')) return parent::toArray($request);
        return [
            'id' => $this->question_id,
            'order' => $this->order,
            'label' => $this->question->label,
            'description' => $this->question->description,
            'options' => new OptionCollection($this->whenLoaded('options')),
        ];
    }
}
