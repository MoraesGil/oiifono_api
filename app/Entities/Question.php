<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Traits\Models\UuidCrc32;
class Question extends Model
{
    use UuidCrc32;

    const UUID_FIELDS = ['label'];
    protected $fillable = ['label','description'];
    public $timestamps = false;

    public function protocols()
    {
        return $this->belongsToMany(Protocol::class, 'protocol_questions')->using(ProtocolQuestion::class)->withPivot(['order']);
    }
}
