<?php

namespace App\Entities;
use App\Entities\Person;
use Illuminate\Database\Eloquent\Model;

class Individual extends Model
{
    protected $primaryKey = "person_id";
    protected $fillable = ["birth_date", "cpf", "rg","sex","disabilities"];
    public $timestamps = false;

    public function person()
    {
        return $this->belongsTo(Person::class,"id","person_id");
    }

    public function hospitalization()
    {
        return $this->hasOne(Hospitalization::class,'id','person_id');
    }




}

