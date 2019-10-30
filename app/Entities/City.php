<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\State;
class City extends Model
{

    protected $fillable = ['id', 'name', 'uf'];
    public $timestamps = false;

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
