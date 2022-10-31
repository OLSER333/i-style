<?php

namespace App\Classes\Database;

class Table extends Constructor
{
    public function __construct(string $table_name, array $columns = [], array $properties = [])
    {
        $this->_i = [];
        $this->_i['table_name'] = $table_name;
        $this->_i = array_merge($this->_i, $properties);
        if(!empty($columns))
            $this->set_columns_from_array($columns);
    }

    public function set_columns(Column ...$column)
    {
        $columns = func_get_args();
            $this->set_columns_from_array($columns);
    }

    public function set_columns_from_array(array $columns)
    {
        foreach($columns as $column) {
            $column_name = strtolower($column->column_name);
            if($column_name[0] == '$') {
                $column_name = str_replace('$_', $this->_i['table_name'].'_', $column_name);
            } else if($column_name[0] == '&') {
                $column_name = explode('.', $column_name)[1];
            }
            $this->$column_name = $column;
            $this->$column_name->column_name = $column_name;
        }
    }
}
