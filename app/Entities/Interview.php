<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    protected $fillable = ['overview', 'protocol_id'];

    public function answers()
    {
        return $this->belongsToMany(Question::class, 'interview_answers')->withPivot(['option_id', 'answer']);
    }
}
