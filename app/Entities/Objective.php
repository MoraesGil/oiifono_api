<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Objective extends Model
{
    protected $fillable = ['repeat', 'minutes', 'description'];
    public $timestamps = false;

    public function therapy()
    {
        return $this->belongsTo(Therapy::class);
    }

    public function strategy()
    {
        return $this->hasOne(Strategy::class);
    }

    public function pathology()
    {
        return $this->hasOne(Pathology::class);
    }

    public function appointment()
    {
        return $this->belongsToMany(Appointment::class, 'done_objectives');
    }
}
