<?php

namespace App\Helpers\Traits\Models;

use App\Helpers\BatmanBelt;

trait UuidCrc32
{
    /**
     * Ovveride ID before Save generating CRC32 ID
     *
     * @return void
     */
    public static function bootUuidCrc32()
    {
        static::saving(function ($model) {
            $model->incrementing = false;
            $model->{$model->primaryKey} = BatmanBelt::generateUuidCrc32(
                BatmanBelt::modelToValues($model, self::UUID_FIELDS)
            );

            if ($model->{$model->primaryKey} == 0 || null){
                throw new Exception("unable to generate crc32, check your model data", 1);
            }
        });
    }
}
