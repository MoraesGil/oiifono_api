<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Protocol extends Model
{
    protected $fillable = ['type', 'title'];
    public $timestamps = false;

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'protocol_questions')->withPivot(['order']);
    }
}
