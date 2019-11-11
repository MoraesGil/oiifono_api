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
    protected $fillable = ['overview'];

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

    public function evolution()
    {
        return $this->belongsToMany(Question::class, 'interview_answers')->withPivot(['option_id', 'answer']);
    }
}
