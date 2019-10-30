<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Doctor;
use App\Entities\Hospitalization;
use App\Entities\Objective;

class Therapy extends Model
{
    protected $fillable = ['hospitalization_id', 'doctor_id', 'description'];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function hospitalization()
    {
        return $this->belongsTo(Hospitalization::class);
    }

    public function objectives()
    {
        return $this->hasMany(Objective::class);
    }
}
