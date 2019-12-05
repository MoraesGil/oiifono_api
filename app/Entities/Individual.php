<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Person;
use App\Entities\Hospitalization;
use App\Helpers\BatmanBelt;

class Individual extends Model
{
    protected $primaryKey = "person_id";
    
    protected $fillable = ["birth_date", "cpf", "rg", "gender", "disabilities"];
    
    protected $dates = ['birthdate'];

    public $timestamps = false;



    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'person_id');
    }

    public function hospitalizations()
    {
        return $this->hasMany(Hospitalization::class, 'person_id', 'person_id');
    }

    public function hospitalization()
    {
        return $this->hospitalizations()->whereNull('discharged')->first();
    }
}
