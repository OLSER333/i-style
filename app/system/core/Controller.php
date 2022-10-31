<?php

namespace App\System\Core;

use const App\ROOT\ABSPATH;

class Controller
{
    public bool $is_current_url = true;

    function loadTheme(string $themeName)
    {
        $themeConfig = ABSPATH."/themes/$themeName/config.php";
        include_once $themeConfig;
    }
}
