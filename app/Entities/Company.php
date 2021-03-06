<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Person;
use App\Entities\HealthPlan;
class Company extends Model
{
    protected $primaryKey = "person_id";
    protected $fillable = ["cnpj", "ie"];
    public $timestamps = false;

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function healthPlans()
    {
        return $this->hasMany(HealthPlan::class,'company_id');
    }
}
