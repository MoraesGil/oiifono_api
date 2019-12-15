<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Patient;
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
        $this->withoutWrapping();
        return [
            'id' => $this->id,
            'date' => $this->date,
            'start_at' => $this->start_at->format('H:i'),
            'end_at' => $this->end_at->format('H:i'),
            'confirmed' => $this->confirmed,
            'absence_by' => $this->absence_by,
            'parent' => $this->parent_id,
            'patient' => new Patient($this->patient->person),
            'rescheduled' => !!count($this->reschedules ? $this->reschedules : [])
        ];
    }
}
