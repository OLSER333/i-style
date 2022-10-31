<?php

namespace Themes\Regular\Models;

class DashboardContentModel extends RegularModel
{
    function __construct(string $viewName, array $variables = [])
    {
        parent::__construct('layouts/dashboard-content', [
            'content' => new RegularModel($viewName, $variables)
        ]);
    }
}
