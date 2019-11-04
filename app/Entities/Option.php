<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Question;
use App\Helpers\Traits\Models\ModelUuidTrait;

class Option extends Model
{
    use ModelUuidTrait;

    private static $uuidFields = ['label','lines','parent'];
    protected $fillable = ['id', 'label', 'lines', 'parent_id'];
    public $timestamps = false;

    public function parent()
    {
        return $this->belongsTo(Option::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'question_options')->withPivot(['group']);
    }

    public static function boot()
    {
        parent::boot();

        self::saving(function ($model) {
            $model["id"] = self::generateUuid($model);
        });
    }
}
