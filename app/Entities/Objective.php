<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Therapy;
use App\Entities\Strategy;
use App\Entities\Pathology;
use App\Entities\Appointment;

class Objective extends Model
{
    protected $fillable = ['repeat', 'minutes', 'description', 'pathology_id', 'strategy_id', 'therapy_id'];
    public $timestamps = false;
    protected $hidden = [
        'therapy_id',
        'pathology_id',
        'strategy_id'
    ];


    public function getRepetitionsRemainingAttribute()
    {
        return $this->repeat - $this->appointments->count();
    }

    public function therapy()
    {
        return $this->belongsTo(Therapy::class);
    }

    public function strategy()
    {
        return $this->belongsTo(Strategy::class);
    }

    public function pathology()
    {
        return $this->belongsTo(Pathology::class);
    }

    public function appointments()
    {
        return $this->belongsToMany(Appointment::class, 'done_objectives');
    }
}
