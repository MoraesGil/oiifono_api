<?

namespace App\Helpers;

class BatmanBelt
{
    public static function RuleExcept($rules, $id = null){
        $id = $id ? $id : 'NULL';
        $rules = json_encode($rules);
        $rules = str_replace('@except',$id,$rules);
        return json_decode($rules,true);
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
