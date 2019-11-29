<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProtocolQuestion extends Pivot
{
    public $incrementing = true;
    public $timestamps = false;
    protected $table = "protocol_questions";
    protected $fillable = ['order', 'protocol_id', 'question_id'];

    public function protocol()
    {
        return $this->belongsTo(Protocol::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function options()
    {
        return $this->belongsToMany(Option::class, 'question_options', 'protocol_question_id')->withPivot(['order', 'group']);
    }
}
