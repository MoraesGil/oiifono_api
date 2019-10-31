<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\ActingArea;
use App\Helpers\Traits\Models\ModelUuidTrait;
class Pathology extends Model
{
    //id from uuid of cid
    use ModelUuidTrait;
    private static $uuidFields = ['cid'];

    protected $fillable = ['cid','label', 'description'];

    public function actingArea()
    {
        return $this->hasOne(ActingArea::class);
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model["id"] = self::generateUuid($model);
        });
    }
}
