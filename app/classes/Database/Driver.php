<?php

namespace App\Classes\Database;

use function App\app;

const LOG_MODE = 1;
const TABLE_ID = 1;

class Driver
{

    function __construct(
        public string $host,
        public string $user,
        public string $pass,
        public string $name
    ) {}

    private function open(bool $setup_db = false)
    {
        $mysqli = new \mysqli($this->host, $this->user, $this->pass);
        if($mysqli->connect_error) {
            die('Connect error');
        }
        if($setup_db) {
            if($mysqli->query('CREATE DATABASE IF NOT EXISTS '.$this->name)) {
                echo 'База данных установлена.';
                exit;
            } else {
                echo 'Ошибка. База данных не установлена.';
                exit;
            }  
        }
        $mysqli->select_db($this->name);
        $mysqli->set_charset('utf8');
        $this->mysli = $mysqli;
        return $mysqli;
    }

    public function do($query, $multi = false, bool $setup_db = false)
    {
        try {
            $mysqli = $this->open($setup_db);
            if($multi)
                $result = $mysqli->multi_query($query);
            else
                $result = $mysqli->query($query);
            if($mysqli->error) {
                $this->error[] = "Error $mysqli->errno : $mysqli->error";
            }
            if(LOG_MODE)
                $this->query[] = $query;
            if(is_numeric($mysqli->insert_id))
                $this->insert_id = $mysqli->insert_id; 
            $mysqli->close();
            return $result;
        } catch (\Throwable $th) {
            $this->errors[] = $th->getMessage();
            return [];
        }
        
    }

    public function select($query)
    {
        $result = $this->do($query);
        if($result) {
            $array = $result->fetch_all(MYSQLI_ASSOC);
            $result->free();
            if(LOG_MODE)
                $this->responce[] = $array;
            return $array;
        }
    }

    public function find_one($query) {
        return $this->select($query)[0];
    }

    public function insert(string $table, array $data)
    {
        $query = "INSERT INTO `$table` (%s) VALUES (%s);";
        $columns = array();
        $Values = array();

        $Database = app()->tables;
        $dateAddCol = $table.'_date_add';
        if(!isset($columns[$dateAddCol]) and isset($Database->$table->$dateAddCol)) {
            $data[$dateAddCol] = time();
        }

        foreach($data as $key => $value) {
            $Values[] = "'$value'";
            $columns[] = $key;
        }
        
        $query = sprintf($query, implode(", ", $columns), implode(", ", $Values));

        try {
            $this->do($query);
        } catch (\Throwable $th) {
            //throw $th;
            // exit($th->getMessage());
        }
    }

    public function update($table, $data, $id)
    {
        $Database = app()->tables;
        $query = "UPDATE `$table` SET ";
        foreach($data as $key => $value) {
            if($Database->$table->$key->value->type == 'int' and $value == '')
                continue;
            $query.= $key ." = '$value', ";
        }
        if(TABLE_ID)
            $col = $table.'_id';
        else
            $col = 'ID';
        $query = trim($query, ", ")." WHERE $col = $id;";
        return $this->do($query);
    }


    function findByID(string $table, int $id, string $columns = '*')
    {
        if(TABLE_ID)
            $col = $table.'_id';
        else
            $col = 'ID';
        $query = [$col => $id];
        return $this->findOne($table, $query, $columns);
    }

    function findOne(string $table, array $query, string $columns = '*')
    {
        if(empty($query))
            return false;
        $result = $this->find($table, $query, $columns);
        if(!empty($result))
            return $result[0];
        else
            return false;
    }

    function find(string $table, array $query = [], string $columns = '*', string|null $orderBy = null, bool $desc = false)
    {
        $sqlArray = [];
        if(!empty($query)) {
            foreach($query as $key => $value) {
                if(is_int($value) or is_float($value) or is_bool($value))
                    $sqlArray[] = "$key = $value";
                else
                    $sqlArray[] = "$key = '$value'";
            }
            $sqlQuery = "SELECT $columns FROM `$table` WHERE ".implode(' AND ', $sqlArray);
        } else {
            $sqlQuery = "SELECT $columns FROM `$table`";
        }
        if($orderBy !== null) {
            $sqlQuery.= " ORDER BY $orderBy";
            if($desc !== false) {
                $sqlQuery.= ' DESC';
            } else {
                $sqlQuery.= ' ASC';
            }
        }
        $result = $this->select($sqlQuery);
        return $result;
    }
}
