<?php

namespace Themes\Regular\Models;

class Error404Model extends RegularModel
{
    function __construct()
    {
        $variables = [
            'title' => 'Ошибка 404',
            'content' => new RegularModel('content/404')
        ];
        parent::__construct("layouts/wrapper", $variables);
    }
}
