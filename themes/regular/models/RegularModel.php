<?php

namespace Themes\Regular\Models;

use App\System\Core\Model;

use const Themes\Regular\THEME_PATH;

class RegularModel extends Model
{
    function __construct(string $viewName, array $variables = [])
    {
        parent::__construct(THEME_PATH."/views/$viewName.php", $variables);
    }
}
