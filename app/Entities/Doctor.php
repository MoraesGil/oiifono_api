<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Person;

class Doctor extends Model
{
    protected $primaryKey = "person_id";
    protected $fillable = ["register"];
    public $timestamps = false;

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'doctor_id');
    }
}
