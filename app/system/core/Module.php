<?php

namespace App\System\Core;

use function App\System\getPath;
use function App\System\import;
use function App\System\setProperties;

class Module
{

    protected $moduleName = 'module';

    function __construct(protected string $basepath, array $properties = [])
    {
        setProperties($this, $properties);
    }

    function autoload(string $dir, string|null $namespace = null)
    {
        new Autoload(getPath($this->basepath, $dir), $namespace);
    }

    function action(string $name, array $variables = []) : void
    {
        $variables[$this->moduleName] = $this;
        import(getPath($this->basepath, "actions", "$name.php"), $variables);
    }

    function data(string $name, array $variables = []) : void
    {
        $variables[$this->moduleName] = $this;
        import(getPath($this->basepath, "data", "$name.php"), $variables);
    }

    function view(string $name, array $variables = []) : void
    {
        $model = new Model(getPath($this->basepath, "views", "$name.php"), $variables);
        $model->load();
    }

    function getBasepath()
    {
        return $this->basepath;
    }
}
