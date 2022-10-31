<?php

namespace App\Classes\Database;

use function App\app;

use const App\DB_CHARSET;
use const App\DB_NAME;

class CreateTablesQuery
{
    public function __construct(Database $database)
    {
        $this->query = 'set names '.DB_CHARSET.'; use '.DB_NAME.'; ';
        foreach($database as $key => $table) {
            if($key == '_i')
                continue;
            $this->query.= $this->tableQuery($table);
        }
    }

    public function tableQuery(Table $table) : string
    {
        $tableQuery = 'CREATE TABLE IF NOT EXISTS `'.$table->_i['table_name'].'` ( ';
        $columnsArray = [];
        foreach($table as $key => $column) {
            if($key == '_i')
                continue;
            if(isset($column->sql['foreign_table'])) {
                $tablename = $column->sql['foreign_table'];
                $colname = $column->sql['foreign_column'];
                $value = app()->tables->$tablename->$colname->value;
            } else {
                $value = $column->value;
            }
            $column->value = $value;
            $columnsArray[] = $column->column_name.' '.$this->columnQuery($column);
        }
        $tableQuery.= implode(', ', $columnsArray);
        $tableQuery.= ' ); ';
        return $tableQuery;
    }

    public function columnQuery(Column $column)
    {
        
        switch ($column->value->type) {
            case 'string':
                if(isset($column->value->length))
                    $query = 'CHAR('.$column->value->length.')';
                else if($column->value->max_length <= 2048)
                    $query = 'VARCHAR('.$column->value->max_length.')';
                else if($column->value->max_length > 2048)
                    $query = 'TEXT';
                else if($column->value->max_length > 65000)
                    $query = 'MEDIUMTEXT';
                else
                    $query = 'VARCHAR(255)';
                break;
            
            case 'int':
                if(isset($column->value->length))
                    $length = $column->value->length;
                else if(isset($column->value->max_length))
                    $length = $column->value->max_length;

                if($length <= 9)
                    $query = "INT($length)";
                else
                    $query = "BIGINT($length)";
                    
                if(!isset($column->value->negative)) {
                    $query.= " UNSIGNED";
                }
                break;

            case 'float':
                $query = 'DECIMAL('.$column->value->float[0].','.$column->value->float[1].')';
                break;

            case 'bool':
                $query = 'BOOLEAN';
                break;
        }
        $postQuery = [];
        if(isset($column->sql['not_null'])) {
            $query.= ' NOT NULL';
        }
       
        if(isset($column->sql['primary_key'])) {
            $query.= ' PRIMARY KEY';
            if($column->value->type == 'int') {
                $query.= ' AUTO_INCREMENT';  
            }
        }
        if(isset($column->sql['default'])) {
            $def = $column->sql['default'];
            $query.= " DEFAULT '$def'";
        }
        $setIndexes = function($column, $key) {
            if(isset($column->sql[$key])) {
                $index = $column->sql[$key];
                if(is_bool($index))
                    return $key.'('.$column->column_name.')';
                if(is_array($index))
                    return $key.'('.$index[0].','.$index[1].')';
            }
        };
        if($indexQuery = $setIndexes($column, 'index')) {
            $postQuery[] = $indexQuery;
        }
        if($uniqueQuery = $setIndexes($column, 'unique')) {
            $postQuery[] = $uniqueQuery;
        }
        if(isset($column->sql['foreign_table'])) {
            if(!isset($column->sql['not_null'])) {
                $query.= ' NOT NULL';
            }
            $postQuery[] = 'FOREIGN KEY('.$column->column_name.') REFERENCES `'.$column->sql['foreign_table'].'` ('.$column->sql['foreign_column'].') ON DELETE RESTRICT ON UPDATE CASCADE';
        }

        if(!empty($postQuery)) {
            $query.= ', '.implode(',', $postQuery);
        }
        return $query;
    }
}
