<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Pathology extends Model
{

    protected $fillable = ['label', 'description'];
    public $timestamps = false;

}
