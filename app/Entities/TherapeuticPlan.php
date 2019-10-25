<?php
namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Schedule;

class TherapeuticPlan extends Model
{
    protected $fillable = ['hospitalization_id', 'doctor_id','objective'];

    public function cities()
    {
        return $this->hasMany(Schedule::class);
    }


}
