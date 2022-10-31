<?php

namespace App\Classes\Database;

abstract class Constructor
{
    public function __construct(string $main_key, array $objects)
    {
        $this->set_properties($objects, $main_key);
    }

    public function set_properties(array $objects, string $main_key)
    {
        foreach($objects as $object) {
            $object_key = $object->$main_key;
            $this->$object_key = $object;
        }
    }
}
