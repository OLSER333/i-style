<?php

namespace App\Classes\Database;

class Values extends Constructor
{
    public function __construct(value ...$value)
    {
        $Values_arr = func_get_args();
        parent::__construct('key', $Values_arr);
    }
    
    public function add(value ...$value)
    {
        $Values_arr = func_get_args();
        $this->set_properties($Values_arr, 'key');
        if(count($Values_arr) == 1)
            return $Values_arr[0];
    }
}
