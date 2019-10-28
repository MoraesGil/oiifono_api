<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['overview'];
    public $timestamps = false;

    public function hospitalization()
    {
        return $this->hasOne(Hospitalization::class);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function healthPlan()
    {
        return $this->hasOne(HealthPlan::class);
    }

    public function schedule()
    {
        return $this->hasOne(Schedule::class);
    }

    public function objectives()
    {
        return $this->belongsToMany(Objective::class, 'done_objectives');
    }
}
