<?php

namespace App\Classes\Menu;

class Menu
{
    public function __construct(string $name, MenuItem ...$item)
    {
        $this->name = $name;
        $this->items = array();
        $this->add(...$item);
    }

    public function add(MenuItem ...$item)
    {
        $items = func_get_args();
        foreach($items as $item) {
            $this->items[] = $item;
        }
    }
}
