<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\City;
use App\Entities\Person;
class Address extends Model
{
    protected $fillable = ['person_id', 'city_id', 'address', 'district', 'zipcode', 'complements'];
    public $timestamps = false;

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
