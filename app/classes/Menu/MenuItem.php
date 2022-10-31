<?php

namespace App\Classes\Menu;

use function App\app;
use function App\get_request_url;

class MenuItem
{
    public function __construct(string $title, string $url, $icon = '', $after = '', string $activeClass = '', string $inactiveClass = 'collapsed')
    {
        $this->after = $after;
        $this->key = $title;
        $this->title = $title;

        $icons = app()->data['icons'];
        if($icon === true and $icons[$this->key] != '') {
            $this->icon = $icons[$this->key];
        } else if($icon !== '') {
            $itemIcon = $icons[$icon];
            if(isset($itemIcon) and $itemIcon != '')
                $this->icon = $itemIcon;
            else
                $this->icon = $icons['default'];
        }

        $this->url = $url;
        if(trim(get_request_url(), '/') == trim($url, '/'))
            $this->active = $activeClass;
        else
            $this->active = $inactiveClass;
    }
}
