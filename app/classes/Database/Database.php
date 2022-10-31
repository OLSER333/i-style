<?php

namespace App\Classes\Database;

class Database
{
    public function __construct(string $db_name)
    {
        $this->_i = [];
        $this->_i['db_name'] = $db_name;
    }

    public function set_tables(Table ...$table)
    {
        $tables = func_get_args();
        foreach($tables as $table) {
            $table_name = $table->_i['table_name'];
            $this->$table_name = $table;
        }
    }

    public function set_column_templates(ColumnTemplate ...$ColumnTemplate)
    {
        $ColumnTemplates = func_get_args();
        foreach($ColumnTemplates as $ColumnTemplate) {
            $this->_i['templates'][$ColumnTemplate->name] = $ColumnTemplate;
        }
    }
}
