<?php

namespace App\Classes\Admin;

use App\Classes\Database\Value;

use function App\app;
use function App\db;

class FormInput
{
    public function __construct(string $table_name, string $column_name, $column_data)
    {
        $db = db();
        $database = app()->tables;

        $this->table_name = $table_name;
        $this->column_name = $column_name;
        $this->column_data = $column_data;
        $this->value = $database->$table_name->$column_name->value;

        if(isset($database->$table_name->$column_name->sql['foreign_table'])) {
            $this->type = 'select';
            $table = $database->$table_name->$column_name->sql['foreign_table'];
            $column = $database->$table_name->$column_name->sql['foreign_column'];
            $this->value = $database->$table->$column->value;
            if($table == 'user') {
                $view_key = 'user_email';
            } else {
                $view_key = $table.'_title';
                if(!$database->$table->$view_key) {
                    $view_key = $table.'_name';
                    if(!$database->$table->$view_key) {
                        $view_key = $column;
                    }
                }
            }
            if($view_key != $column)
                $select_data = $db->select("SELECT $view_key, $column FROM $table;");
            else
                $select_data = $db->select("SELECT $view_key FROM $table;");
            $this->data = [];
            foreach($select_data as $row) {
                $this->data[$row[$column]] = $row[$view_key];
            }
        } else {
            if($this->value == '1')
                $this->value = $GLOBALS['Values']->id;
            $this->type = self::get_input_type($this->value);
            if($this->type == 'select') {
                foreach($this->value->select as $option) {
                    $this->data[$option] = $option;
                }
            }
        }
        
    }

    public static function get_input_type(Value $value) : string
    {
        if(isset($value->select) and $value->select)
            return 'select';
        else if($value->type == 'bool')
            return 'checkbox';
        else if($value->type == 'int' and $value->key == 'unix')
            return 'datetime-local';
        else if(isset($value->textarea) and $value->textarea == true and $value->editor == true)
            return 'textarea-editor';
        else if(isset($value->textarea) and $value->textarea == true)
            return 'textarea';
        else if($value->key == 'email')
            return 'email';
        else if($value->key == 'pass') {
            return 'password';
        } else if(isset($value->input) and $value->input === 'file') {
            return 'file';
        } else {
            return 'text';
        }
    }
}
