<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{

    protected $fillable = ['id', 'person_id', 'type', 'description'];
    public $timestamps = false;

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
