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
            $model->{$model->primaryKey} = BatmanBelt::generateUuid(
                BatmanBelt::modelToValues($model, self::UUID_FIELDS)
            );
        });
    }
}
