<?php

namespace App\System\Core;

use function App\System\import;

class Model
{

    function __construct(protected string $view, public array $variables = []) {}

    function __toString() : string
    {
        $this->load();
        return '';
    }

    function load() : void
    {
        import($this->view, $this->variables);
    }
}
