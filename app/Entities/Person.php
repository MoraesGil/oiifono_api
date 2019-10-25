<?php

namespace App\Entities;
use App\Entities\Address;
use Illuminate\Database\Eloquent\Model;
use App\Entities\Individual;
use App\Entities\Company;

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

    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }
}
