<?php

namespace App\Entities;

use App\Entities\Individual;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = ["person_id"];
    protected $primaryKey = "person_id";
    public $timestamps = false;

    public function individual()
    {
        return $this->belongsTo(Individual::class, "person_id","person_id");
    }
}
