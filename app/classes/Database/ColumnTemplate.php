<?php

namespace App\Classes\Database;

use App\System\Core\Variables;

class ColumnTemplate
{
    public function __construct(string $name, string|Value $value, array $sql = [])
    {
        $this->name = $name;
        if(is_string($value))
            $value = Variables::get('app')->values->$value;
        $this->value = $value;
        $this->sql = $sql;
    }  
}
