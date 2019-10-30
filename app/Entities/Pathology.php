<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\ActingArea;
class Pathology extends Model
{
    //id from uuid of cid
    protected $fillable = ['cid','label', 'description'];

    public function actingArea()
    {
        return $this->hasOne(ActingArea::class);
    }
}
