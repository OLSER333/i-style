<?php

namespace App\System\Core;

class Theme extends Module
{

    function __construct(string $basepath)
    {
        parent::__construct($basepath);
        $this->moduleName = 'theme';
    }
}
