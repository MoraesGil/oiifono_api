<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Question;
use App\Helpers\Traits\Models\UuidCrc32;

class Option extends Model
{
    use UuidCrc32;

    const UUID_FIELDS = ['label', 'lines', 'parent_id'];

    protected $fillable = ['label', 'lines', 'parent_id'];
    public $timestamps = false;

    public function options()
    {
        return $this->hasMany(Option::class, 'parent_id');
    }

    public function protocolQuestions()
    {
        return $this->belongsToMany(ProtocolQuestion::class, 'question_options')->withPivot(['order', 'group']);
    }
}
