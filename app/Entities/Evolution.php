<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Evolution extends Pivot
{
    public $table = "evolutions";
    protected $fillable = ['answer', 'appointment_id', 'question_id', 'option_id'];
    public $timestamps = false;

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }
}
