<?php

namespace App;

use App\System\Core\Module;
use App\System\Core\Router;

class App extends Module
{
    public Router $router;

    function __construct()
    {
        parent::__construct(__DIR__);
        $this->autoload('classes', __NAMESPACE__.'\Classes');
        $this->autoload('controllers', __NAMESPACE__.'\Controllers');
        $this->autoload('models', __NAMESPACE__.'\Models');
        $this->moduleName = 'app';
        $this->router = new Router;
    }

    function url(string $path, callable|string $controller) : void
    {
        $this->router->url($path, $controller);
    }
}
