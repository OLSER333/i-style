<?php

namespace Themes\Purple\Models;

use App\System\Core\Model;

use const Themes\Purple\THEME_PATH;

class PurpleModel extends Model
{
    function __construct(string $viewName, array $variables = [])
    {
        parent::__construct(THEME_PATH."/views/$viewName.php", $variables);
    }
}
