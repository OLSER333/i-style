<?php

namespace App\Classes\Database;

use App\System\Core\Variables;

use function App\tofloat;

class ValueValidator
{
    public static function int($value_key, $value)
    {
        $values = Variables::get('app')->values;
        if(isset($values->$value_key->min_value))
            if($value < $values->$value_key->min_value)
                return false;
        if(isset($values->$value_key->max_value))
            if($value > $values->$value_key->max_value)
                return false;
        if(!isset($values->$value_key->negative))
            if($value < 0)
                return false;
        return $value;
    }

    public static function length($value_key, $value)
    {
        $values = Variables::get('app')->values;
        if(isset($values->$value_key->length))
            if(mb_strlen($value) != $values->$value_key->length)
                return false;
        if(isset($values->$value_key->min_length))
            if(mb_strlen($value) < $values->$value_key->min_length)
                return false;
        if(isset($values->$value_key->max_length))
            if(mb_strlen($value) > $values->$value_key->max_length)
                return false;
        return $value;
    }

    public static function select($value_key, $value)
    {
        $values = Variables::get('app')->values;
        $select = $values->$value_key->select;
        if(isset($select)) {
            foreach($select as $option) {
                if($option == $value)
                    return $value;
            }
            return false;
        }
        return $value;
    }

    public static function filter($value_key, $value)
    {
        $values = Variables::get('app')->values;
        if(isset($values->$value_key->filter)) {
            switch($values->$value_key->filter) {
                case 'email':
                    if(check_email($value)) {
                        return $value;
                    } else {
                        return false;
                    }
                case 'url':
                    if(count(explode('.', $value)) < 2) {
                        return false;
                    }
                    if(!filter_var($value, FILTER_VALIDATE_URL))
                        $value = 'https://'.$value;
                    return filter_var($value, FILTER_VALIDATE_URL);  
                case 'text':
                    return htmlspecialchars($value, ENT_QUOTES);
                case 'string':
                    return trim($value);
                case 'slug':
                    return get_slug($value);
                case 'money':
                    $value = tofloat($value, 2);
                    return $value;
                case 'time_range':
                    if(isDateRange($value) === false) {
                        return false;
                    }
                    return $value;
            }
        }
        return $value;
    }
}

function isDateRange(string $dateRange): bool
{
    $valueArr = explode(' - ', $dateRange);
    if(count($valueArr) !== 2) {
        return false;
    }
    if(isValidDate($valueArr[0], 'H:i') === false) {
        return false;
    }
    if(isValidDate($valueArr[1], 'H:i') === false) {
        return false;
    }
    if($valueArr[0] > $valueArr[1]) {
        return false;
    }
    return true;
}

function isValidDate(string $date, string $format = 'Y-m-d'): bool
{
    $dateObj = \DateTime::createFromFormat($format, $date);
    return $dateObj && $dateObj->format($format) == $date;
}

function check_email($email) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    return false;
}



function get_slug($text, string $divider = '_', int $maxLength = 200) {
    $text = mb_strtolower($text);
    // replace non letter or digits by divider
    $text = text_translate($text);
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
    // trim
    $text = trim($text, $divider);
    // remove duplicate divider
    $text = preg_replace('~-+~', $divider, $text);
    // lowercase
    $text = mb_strimwidth($text, 0, $maxLength, '');
    if (empty($text)) {
        return 'n-a';
    }
    return $text;
}


function text_translate($text) {
    return strtr($text, array('??'=>'a','??'=>'b','??'=>'v','??'=>'g','??'=>'d','??'=>'e','??'=>'e','??'=>'j','??'=>'z','??'=>'i','??'=>'y','??'=>'k','??'=>'l','??'=>'m','??'=>'n','??'=>'o','??'=>'p','??'=>'r','??'=>'s','??'=>'t','??'=>'u','??'=>'f','??'=>'h','??'=>'c','??'=>'ch','??'=>'sh','??'=>'shch','??'=>'y','??'=>'e','??'=>'yu','??'=>'ya','??'=>'','??'=>'', '??'=>'A','??'=>'B','??'=>'V','??'=>'G','??'=>'D','??'=>'E','??'=>'E','??'=>'J','??'=>'Z','??'=>'I','??'=>'Y','??'=>'K','??'=>'L','??'=>'M','??'=>'N','??'=>'O','??'=>'P','??'=>'R','??'=>'S','??'=>'T','??'=>'U','??'=>'F','??'=>'H','??'=>'C','??'=>'CH','??'=>'SH','??'=>'SHCH','??'=>'Y','??'=>'E','??'=>'YU','??'=>'YA','??'=>'','??'=>''));
}
