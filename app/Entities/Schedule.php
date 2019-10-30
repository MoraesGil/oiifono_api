<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Person;
use App\Entities\Therapy;
class Schedule extends Model
{
    protected $fillable = ['label', 'type', 'start_at', 'end_at', 'therapy_id', 'parent_id'];

    public function people()
    {
        return $this->belongsToMany(Person::class, 'people_schedule')->withPivot(['host', 'confirmed']);
    }

    public function parent()
    {
        return $this->belongsTo(Schedule::class, 'parent_id');
    }

    public function therapy()
    {
        return $this->belongsTo(Therapy::class);
    }
}
