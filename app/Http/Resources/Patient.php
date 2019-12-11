<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class Patient extends JsonResource
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
            'birthdate' => $this->individual->birthdate->format('Y-m-d'),
            'birthday' => $this->individual->birthdate->isSameDay(Carbon::today()),
            'age' => Carbon::today()->diffInYears($this->individual->birthdate),
            'gender' => $this->individual->gender,
            'disabilities' => $this->individual->disabilities,
            'deathdate' => $this->individual->deathdate,
            'name' => $this->name,
            'nickname' => $this->nickname,
            'picture' => $this->picture,
            'relations' => $this->whenLoaded('relatives'),
            'addresses' => $this->whenLoaded('addresses'),
            'contacts' => $this->whenLoaded('contacts')
        ];
    }
}
