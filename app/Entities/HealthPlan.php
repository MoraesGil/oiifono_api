<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Company;

class HealthPlan extends Model
{
    protected $fillable = ["label"];
    public $timestamps = false;

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
