<?php
namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Person;
use App\Entities\TherapeuticPlan;

class Schedule extends Model
{
    protected $fillable = ['label', 'type','start_at','end_at','terapeutic_plan_id','reschedule_id'];

    public function cities()
    {
        return $this->hasMany(Person::class);
    }

    public function fromSchedule(){
        return $this->belongsTo(Schedule::class,'reschedule_id');
    }

    public function fromTerapy(){
        return $this->belongsTo(TherapeuticPlan::class,'reschedule_id');
    }
}
