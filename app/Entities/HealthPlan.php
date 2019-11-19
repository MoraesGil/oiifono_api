<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Company;
use App\Helpers\Traits\Models\ModelUuidTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
class HealthPlan extends Model
{
    use SoftDeletes;
    use ModelUuidTrait;

    const UUID_FIELDS = ['label'];

    protected $fillable = ["label"];
    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        self::saving(function ($model) {
            $model[$model->primaryKey] = self::generateUuid($model);;
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
