<?php

namespace App\Http\Resources;

use App\Entities\Objective;
use Illuminate\Http\Resources\Json\JsonResource;

class TherapyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $therapyProgress = $this->objectives
            ->map(function (Objective $objective) {
                return $objective->appointments->count() / $objective->repeat;
            })->reduce(function ($totalProgress, $objectiveProgress) {
                return $totalProgress + $objectiveProgress;
            });

        $this->withoutWrapping();
        return array_merge(
            parent::toArray($request),
            [
                'progress' => $therapyProgress / $this->objectives->count(),
                'objectives' => new ObjectiveCollection($this->objectives)
            ]
        );
    }
}
