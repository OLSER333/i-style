<?php

namespace Themes\Purple;

use App\System\Core\Theme;

class PurpleTheme extends Theme
{

    function __construct()
    {
        parent::__construct(__DIR__);
        $this->autoload('models', __NAMESPACE__.'\Models');
    }
}
