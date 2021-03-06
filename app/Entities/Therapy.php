<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Hospitalization;
use App\Entities\Objective;
use App\Entities\Doctor;
use App\Entities\Schedule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\SoftDeletes;
class Therapy extends Model
{
    use SoftDeletes;
    protected $fillable = ['hospitalization_id', 'max_minutes', 'times_week', 'doctor_id', 'description'];

    protected $hidden = [
        'updated_at', "deleted_at"
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'person_id', 'doctor_id');
    }

    public function hospitalization()
    {
        return $this->belongsTo(Hospitalization::class);
    }

    public static function showActive($patient_id)
    {
        $hospitalization = Hospitalization::whereNull('discharged')->wherePersonId($patient_id)->whereHas('therapies', function ($query) {
            $query->whereNull('deleted_at');
        })->with('therapies')->first();

        if(!$hospitalization)
        throw new ModelNotFoundException("Não há therapia ativa para o paciente informado");

        return $hospitalization->therapies()->with([
            'objectives',
            'objectives.strategy',
            'objectives.pathology',
            'objectives.appointments:id'
        ])->first();
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
