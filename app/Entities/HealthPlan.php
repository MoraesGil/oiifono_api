<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Company;
use App\Helpers\Traits\Models\ModelUuidTrait;
class HealthPlan extends Model
{
    use ModelUuidTrait;

    private static $uuidFields = ['label'];
    protected $fillable = ["label"];
    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model["id"] = self::generateUuid($model);
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
