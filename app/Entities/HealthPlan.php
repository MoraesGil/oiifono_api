<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Company;
use App\Helpers\Traits\Models\UuidCrc32;;
use Illuminate\Database\Eloquent\SoftDeletes;
class HealthPlan extends Model
{
    use SoftDeletes;
    use UuidCrc32;

    const UUID_FIELDS = ['label'];

    protected $fillable = ["label"];
    public $timestamps = false;

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
