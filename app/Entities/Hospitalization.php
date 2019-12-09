<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Individual;
use App\Entities\Doctor;
use App\Entities\Therapy;
use App\Entities\HealthPlan;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hospitalization extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'person_id',
        'health_plan_id',
        'discharged',
        'discharged_by',
        'discharged_doctor_id'
    ];

    protected $dates = [
        'discharged',
    ];

    /**
     * Find a person's active Hospitalization. Create one if it doesn't exists.
     */
    public static function activeHospitalization($personId)
    {
        return Hospitalization::updateOrCreate([
            'person_id' => $personId,
            'discharged' => null,
        ]);
    }

    public function individual()
    {
        return $this->belongsTo(Individual::class, "person_id");
    }

    public function discharger()
    {
        return $this->belongsTo(Doctor::class, 'person_id', 'dischange_doctor_id');
    }

    public function therapies()
    {
        return $this->hasMany(Therapy::class);
    }

    public function healthPlan()
    {
        return $this->belongsTo(HealthPlan::class, 'health_plan_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
