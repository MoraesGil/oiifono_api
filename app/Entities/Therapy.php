<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Therapy extends Model
{
    protected $fillable = ['hospitalization_id', 'doctor_id', 'description'];

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function hospitalization()
    {
        return $this->hasOne(Hospitalization::class);
    }

    public function objectives()
    {
        return $this->hasMany(Objective::class);
    }
}
