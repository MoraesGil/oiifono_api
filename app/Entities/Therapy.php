<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Hospitalization;
use App\Entities\Objective;
use App\Entities\Doctor;
use App\Entities\Schedule;
use Illuminate\Database\Eloquent\SoftDeletes;
class Therapy extends Model
{
    use SoftDeletes;
    protected $fillable = ['hospitalization_id', 'doctor_id', 'description'];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class,'person_id','doctor_id');
    }

    public function hospitalization()
    {
        return $this->belongsTo(Hospitalization::class);
    }

    public function objectives()
    {
        return $this->hasMany(Objective::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
