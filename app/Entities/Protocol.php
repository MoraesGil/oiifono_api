<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Question;
use Illuminate\Database\Eloquent\SoftDeletes;
class Protocol extends Model
{
    use SoftDeletes;
    protected $fillable = ['type', 'title'];
}
