<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Question;

class QuestionOption extends Model
{
    protected $table = 'question_options';
    protected $fillable = ['protocol_id', 'question_id', 'option_id', 'parent_question_option_id', 'order', 'group', 'lines'];

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function parent()
    {
        return $this->belongsToMany(QuestionOption::class);
    }
}
