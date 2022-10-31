<?php

namespace App\Models;

use App\System\Core\Model;

use const App\BASEPATH;

class AppModel extends Model
{
    function __construct(string $viewName, array $variables = [])
    {
        parent::__construct(BASEPATH."/views/$viewName.php", $variables);
    }
}
