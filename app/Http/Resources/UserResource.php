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
            $user = array_merge($user, [
                'id' => $this->person->id,
                'name' => $this->person->name,
                'picture' => $this->person->picture,
                'cnpj' => $this->person->company ? $this->person->company->cnpj : null,
                'ie' => $this->person->company ? $this->person->company->ie : null,
                'register' => $this->person->doctor ? $this->person->doctor->register : null
            ]);
        }
        return $user;
    }
}
