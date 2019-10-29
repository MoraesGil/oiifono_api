<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{

    protected $fillable = ['id', 'person_id', 'dayOfWeek', 'start_at', 'end_at'];
    public $timestamps = false;

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
