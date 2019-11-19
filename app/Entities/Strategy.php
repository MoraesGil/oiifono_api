<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Traits\Models\UuidCrc32;

class Strategy extends Model
{
    const UUID_FIELDS = ['label'];

    use UuidCrc32;

    protected $fillable = ['label', 'description'];
    public $timestamps = false;

}
