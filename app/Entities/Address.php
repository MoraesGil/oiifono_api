<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\City;
class Address extends Model
{

    protected $fillable = ['id', 'name', 'uf'];
    public $timestamps = false;

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
