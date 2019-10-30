<?php

namespace App\Helpers\Traits\Models;

trait ModelUuidTrait
{
    /**
     * Merge model fields into string and generate UUID with CRC32
     *
     * @param array $model
     * @param array $fields
     * @return INT CRC32 Int value
     */
    private static function generateUuid($model)
    {
        $fields = self::$uuidFields ?: array_keys($model->getAttributes());

        $data = array_filter($model->getAttributes(), function ($key) use ($fields) {
            return in_array($key, $fields);
        }, ARRAY_FILTER_USE_KEY);

        $stringId = array_reduce($data, function ($carry, $item) {
            try {
                $carry .= strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $item));
            } catch (\Throwable $th) {
                \Log::info($th->getMessage());
            }
            return $carry;
        }, "");

        return crc32($stringId);
    }
}
