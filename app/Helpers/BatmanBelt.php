<?php

namespace App\Helpers;

class BatmanBelt
{
    /**
     * get as array values of model by columns names
     * null columns name return all columns
     * @param [Eloquent] $model
     * @param [array] $columns
     * @return array
     */
    public static function modelToValues($model, $columns = null): array
    {
        $columns = $columns ?: array_keys($model->getAttributes());
        return array_filter($model->getAttributes(), function ($key) use ($columns) {
            return in_array($key, $columns);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * Merge model fields into string and generate UUID with CRC32
     *
     * @param array $values
     * @return int CRC32 Int value
     */
    public static function generateUuid($values): int
    {
        $computedData = array_reduce($values, function ($carry, $item) {
            try {
                if($item)
                $carry .= strtolower(self::cleanWhiteSpaces(self::cleanAccents($item)));
            } catch (\Throwable $th) {
                \Log::info($th->getMessage());
            }
            return $carry;
        }, "");
        $id = crc32($computedData);

        if ($id == 0 || null)
            throw new Exception("Too big ID, check you source data", 1);

        return $id;
    }

    /**
     * remove all whitespace including tabs and line ends
     *
     * @param [type] $string
     * @return String
     */
    public static function cleanAccents($string): string
    {
        return iconv('UTF-8', 'ASCII//TRANSLIT', $string);
    }

    /**
     * remove all whitespace including tabs and line ends
     *
     * @param [type] $string
     * @return String
     */
    public static function cleanWhiteSpaces($string)
    {
        return preg_replace('/\s+/', '', $string);
    }


    public static function RuleExcept($rules, $id = null)
    {
        $id = $id ? $id : 'NULL';
        $rules = json_encode($rules);
        $rules = str_replace('@except', $id, $rules);
        return json_decode($rules, true);
    }

    public static function mask($val, $mask)
    {
        $val = str_replace(".", "", $val);
        $val = str_replace("-", "", $val);
        $maskared = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; $i++) {
            if ($mask[$i] == '#') {
                if (isset($val[$k]))
                    $maskared .= $val[$k++];
            } else {
                if (isset($mask[$i]))
                    $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }
}
