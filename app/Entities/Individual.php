<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Person;
use App\Entities\Hospitalization;
use App\Helpers\BatmanBelt;

class Individual extends Model
{
    protected $primaryKey = "person_id";
    protected $fillable = ["birth_date", "cpf", "rg", "sex", "disabilities"];
    public $timestamps = false;

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function hospitalizations()
    {
        return $this->hasMany(Hospitalization::class, 'person_id', 'person_id');
    }

    public function hospitalization()
    {
        return $this->hospitalizations()->whereNull('discharge')->first();
    }

}
