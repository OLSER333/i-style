<?php

namespace App\Classes\Database;

class ValueConverter
{
    public function new_method($name, $method = '')
    {
        if($method == '')
            $this->$name = $name;
        else
            $this->$name = $method;
    }
    public function convert($method_name, $value)
    {
        $function = $this->$method_name;
        return $function($value);
    }
}
