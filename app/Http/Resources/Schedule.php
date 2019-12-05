<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Schedule extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'start_at' => $this->start_at->format('H:i'),
            'end_at' => $this->end_at->format('H:i'),
            'confirmed' => $this->confirmed,
            'absence_by' => $this->absence_by,
            'parent_id' => $this->parent_id,
            'person_id' => $this->person_id,
            'rescheduled' => !!count($this->reschedules ? $this->reschedules : [])
        ];
    }
}
