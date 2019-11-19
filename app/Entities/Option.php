<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Question;
use App\Helpers\Traits\Models\UuidCrc32;

class Option extends Model
{
    use UuidCrc32;

    const UUID_FIELDS = ['label','lines','parent_id'];

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

}
