<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ActingArea extends Model
{
    protected $fillable = ['label', 'description'];

    public function pathologies()
    {
        return $this->hasMany(Pathology::class);
    }
}
