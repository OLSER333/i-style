<?php

namespace App\Classes\Database;

use App\System\Core\Variables;

use function App\app;

class Column
{
    public function __construct(string $column_name, string|Value|bool $value = true, array $sql = [])
    {
        $this->column_name = $column_name;
        if(is_string($value))
            $value = Variables::get('app')->values->$value;
        $this->value = $value;
        $this->sql = $sql;
        $this->parce_name();
        if(is_bool($this->value) and !isset($this->sql['foreign_table']))
            $this->value = app()->values->default;
    }

    public function parce_name()
    {
        $name = $this->column_name;
        switch ($name[0]) {
            case '$':
                $name = str_replace('$_', '', $name);
                $tables = Variables::get('app')->tables;
                $template = $tables->_i['templates'][$name];
                if(isset($template)) {
                    if($this->value === true) {
                        $this->value = $template->value;
                    }
                    if(empty($this->sql)) {
                        $this->sql = $template->sql;
                    }
                }
                break;

            case '&':
                $name = str_replace('&_', '', $name);
                $foreign_array = explode('.', $name);
                $this->sql['not_null'] = 1;
                $this->sql['foreign_table'] = $foreign_array[0];
                $this->sql['foreign_column'] = $foreign_array[1];
                break;
        }
    }
}
