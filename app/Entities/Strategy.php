<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Strategy extends Model
{
    protected $fillable = ['label', 'description'];
    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model["id"] = self::getIntUuid($model);
        });
    }

    /**
     * Merge model fields into string and generate UUID with CRC32
     *
     * @param array $model
     * @param array $fields
     * @return INT CRC32 Int value
     */
    private static function getIntUuid(Array $model, $fields = [])
    {
        $fields = $fields ?: array_keys($model);

        $data = array_filter($model, function ($key) use ($fields) {
            return in_array($key, $fields);
        }, ARRAY_FILTER_USE_KEY);

        $stringId = array_reduce($data, function ($carry, $item) {
            $carry .= iconv('UTF-8', 'ASCII//TRANSLIT', $item);
            return $carry;
        }, "");

        return crc32($stringId);
    }
}
