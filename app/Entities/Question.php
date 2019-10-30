<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Protocol;
use App\Entities\Option;

class Question extends Model
{
    protected $fillable = ['id', 'label', 'lines', 'description'];
    public $timestamps = false;

    public function protocols()
    {
        return $this->belongsToMany(Protocol::class, 'protocol_questions')->withPivot(['order']);
    }

    public function options()
    {
        return $this->belongsToMany(Option::class, 'question_options')->withPivot(['group']);
    }
}
