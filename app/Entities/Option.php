<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Question;
use App\Helpers\Traits\Models\UuidCrc32;

class Option extends Model
{
    use UuidCrc32;

    const UUID_FIELDS = ['label'];

    protected $fillable = ['label'];
    public $timestamps = false;
}
