<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Individual;
use App\Entities\Doctor;
use App\Entities\Therapy;

class Hospitalization extends Model
{
    protected $fillable = ["patient_id", "health_plan_id"];

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
}
