<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Hospitalization;
use App\Entities\Doctor;
use App\Entities\Schedule;
use App\Entities\Objective;
use App\Entities\Question;
use App\Entities\HealthPlan;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'doctor_id',
        'hospitalizaion_id',
        'overview',
        'health_plan_id',
        'schedule_id',
        'protocol_id'
    ];

    public $timestamps = false;

    public function hospitalization()
    {
        return $this->belongsTo(Hospitalization::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'person_id');
    }

    public function healthPlan()
    {
        return $this->belongsTo(HealthPlan::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function objectives()
    {
        return $this->belongsToMany(Objective::class, 'done_objectives');
    }

    public function evolutions()
    {
        return $this->hasMany(Evolution::class);
    }
}
