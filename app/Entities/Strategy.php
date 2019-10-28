<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Strategy extends Model
{
    protected $fillable = ['label', 'description'];
    public $timestamps = false;
}
