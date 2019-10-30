<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Question;

class Option extends Model
{

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
