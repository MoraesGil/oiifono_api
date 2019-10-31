<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Individual;
use App\Entities\Company;
use App\Entities\Address;
use App\Entities\Schedule;
use App\Entities\Doctor;
use App\Entities\Availability;
use App\Entities\Contact;

class Person extends Model
{
    protected $fillable = ["name", "nickname"];

    public function parent()
    {
        return $this->belongsToMany(Person::class, 'relations', 'person_id', 'parent_id')
            ->withTimestamps()
            ->withPivot('order', 'kinship');
    }

    public function individual()
    {
        return $this->hasOne(Individual::class);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function contacts()
    {
        return $this->hasMany(Address::class);
    }

    public function availability()
    {
        return $this->hasMany(Availability::class, 'person_id', 'id');
    }

    public function schedules()
    {
        return $this->belongsToMany(Schedule::class, 'people_schedule')->withPivot(['host', 'confirmed']);
    }
}
