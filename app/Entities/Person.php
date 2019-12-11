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
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use SoftDeletes;
    protected $fillable = ["name", "nickname"];

    public function relatives()
    {
        return $this->belongsToMany(Person::class, 'relations', 'person_id', 'parent_id')
            ->withPivot('order', 'kinship', 'contact');
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

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function availabilities()
    {
        return $this->hasMany(Availability::class, 'person_id', 'id');
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public static function patients()
    {
        return self::query()
            ->whereHas('individual')
            ->doesntHave('doctor');
    }
}
