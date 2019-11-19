<?php

namespace App\Helpers\Traits\Models;

use App\Helpers\BatmanBelt;

trait ModelUuidTrait
{
    /**
     * Merge model fields into string and generate UUID with CRC32
     *
     * @param array $model
     * @param array $fields
     * @return INT CRC32 Int value
     */
    private static function generateUuid($model): int
    {
        return BatmanBelt::generateUuid(
            BatmanBelt::modelToValues($model, self::UUID_FIELDS)
        );
    }
}
