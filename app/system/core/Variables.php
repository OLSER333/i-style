<?php

namespace App\System\Core;

class Variables
{
    static array $data;
    
    static function add(mixed $value, string $variable) : mixed
    {
        Variables::$data[$variable] = $value;
        return $value;
    }

    static function get(string $variable) : mixed
    {
        if(!isset(Variables::$data[$variable]))
            return false;
        return Variables::$data[$variable];
    }
}
