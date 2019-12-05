<?php

namespace App\Http\Resources;

use App\Entities\Person;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = [
            'id' => $this->id,
            'email' => $this->email,
        ];

        if ($this->person) {
            $user['person'] = [
                'id' => $this->person->id,
                'name' => $this->person->name,
                'picture' => $this->person->picture,
                'company'=>[
                    'cnpj' => $this->person->company ? $this->person->company->cnpj : null,
                    'ie' => $this->person->company ? $this->person->company->ie : null,
                ],
                'doctor'=>[
                    'crfa' => $this->person->doctor ? $this->person->doctor->register : null,
                ],
                'availabilities' => $this->person->availabilities
            ];
        }
        return $user;
    }
}
