<?php

namespace App\Entities;

use App\Entities\Individual;
use Illuminate\Database\Eloquent\Model;

class Hospitalization extends Model
{
    protected $fillable = ["patient_id", "health_plan_id"];
    public $timestamps = false;

    public function individual()
    {
        return $this->belongsTo(Individual::class, "person_id");
    }


    /**
     * Get a doctor info who give dischange to patient
     *
     * @return Doctor
     */
    public function discharger()
    {
        return $this->hasOne(Doctor::class, 'id', 'person_id');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function therapy()
    {
        return $this->belongsTo(Therapy::class);
    }
}
