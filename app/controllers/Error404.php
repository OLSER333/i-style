<?php

namespace App\Controllers;

use Themes\Purple\Models\Error404Model;
use App\System\Core\Controller;

class Error404 extends Controller
{

    function __construct()
    {
        $this->loadTheme('purple');
        $this->model = new Error404Model();
        $this->model->load();
    }
}
