<?php

namespace App\System\Core;

use function App\System\strReplaceFirst;

class Autoload
{
    function __construct(public string $basepath, public string|null $namespace = null)
    {
        spl_autoload_register(function($class){
            if($this->namespace !== null)
                $class = strReplaceFirst($this->namespace, '', $class);
            $file = $this->basepath."/$class.php";
            $file = str_replace(['/', '\\', '//', '\\\\'], '/', $file);
            if(file_exists($file))
                include_once $file;
        });
    }
}
