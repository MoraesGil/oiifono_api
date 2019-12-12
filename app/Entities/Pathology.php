<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\ActingArea;
use App\Helpers\Traits\Models\UuidCrc32;
class Pathology extends Model
{
    //id from uuid of cid
    use UuidCrc32;
    const UUID_FIELDS = ['cid'];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $fillable = ['cid','label', 'description'];

    public function actingArea()
    {
        return $this->hasOne(ActingArea::class);
    }
}
