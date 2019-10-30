<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Traits\Entities\EntityValidatorTrait;

class ActingArea extends Model
{
    use EntityValidatorTrait;
    protected $fillable = ['label', 'description'];

    public function pathologies()
    {
        return $this->hasMany(Pathology::class);
    }
}
