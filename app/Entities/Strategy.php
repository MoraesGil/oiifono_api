<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Traits\Models\ModelUuidTrait;

class Strategy extends Model
{
    use ModelUuidTrait;

    protected $fillable = ['label', 'description'];
    public $timestamps = false;

    private static $uuidFields = ['label'];

    public static function boot()
    {
        parent::boot();

        self::saving(function ($model) {
            $model["id"] = self::generateUuid($model);
        });
    }
}
