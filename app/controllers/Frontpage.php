<?php

namespace App\Controllers;

use App\System\Core\Controller;
use Themes\Purple\Models\LandingModel;

class Frontpage extends Controller
{

    function __construct()
    {
        $this->loadTheme('purple');
    }

    function main()
    {
        $this->model = new LandingModel();
        $this->model->load();
    }
}
