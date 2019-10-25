<?php

namespace App\Entities;

use App\Entities\Individual;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = ["register"];
    public $timestamps = false;

    public function person()
    {
        return $this->belongsTo(Individual::class,"id","person_id");
    }
}
