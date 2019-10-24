<?php

namespace App\Entities;
use App\Entities\Person;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Individual extends Model
{
    protected $primaryKey = "person_id";
    protected $fillable = ["birth_date", "cpf", "rg","sex"];
    public $timestamps = false;

    public function person()
    {
        return $this->belongsTo(Person::class,"id","person_id");
    }

    public function patient()
    {
        return $this->hasOne(Patient::class, "person_id","person_id");
    }


}

