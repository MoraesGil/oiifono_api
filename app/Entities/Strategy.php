<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Traits\Models\ModelUuidTrait;

class Strategy extends Model
{
    const UUID_FIELDS = ['label'];

    use ModelUuidTrait;

    protected $fillable = ['label', 'description'];
    public $timestamps = false;


    public static function boot()
    {
        parent::boot();

        self::saving(function ($model) {
            $model[$model->primaryKey] = self::generateUuid($model);;
        });
    }
}
