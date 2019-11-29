<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;

class Option extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $suboptions = $this->options;
        return [
            'id' => $this->id,
            'label' => $this->label,
            'lines' => $this->lines,
            'options' => count($suboptions) ? new OptionCollection($suboptions) : new MissingValue
        ];
    }
}
