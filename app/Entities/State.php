<?php
namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\City;
class State extends Model
{
    protected $fillable = ['uf', 'name'];
    public $timestamps = false;

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
