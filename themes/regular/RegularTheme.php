<?php

namespace Themes\Regular;

use App\System\Core\Theme;

class RegularTheme extends Theme
{

    function __construct()
    {
        parent::__construct(__DIR__);
        $this->autoload('models', __NAMESPACE__.'\Models');
    }
}
