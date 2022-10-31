<?php

namespace Themes\Regular\Models;

use App\System\Core\Model;

use function App\app;

class DashboardModel extends RegularModel
{
    function __construct(string $title, Model $content, array $variables = [], array $breadcrumbs = [])
    {
        $keywords = app()->options['meta_keywords'];
        $description = app()->options['meta_description'];
        
        $variables = array_merge($variables, [
            'title' => $title,
            'keywords' => $keywords,
            'description' => $description,
            'content' => new RegularModel('layouts/dashboard', [
                'header' => new HeaderModel(),
                'title' => $title,
                'sidebar' => new RegularModel('blocks/sidebar', ['menu' => app()->menu]),
                'breadcrumbs' => $breadcrumbs,
                'content' => $content,
                'footer' => new RegularModel('blocks/footer')
            ])
        ]);
        parent::__construct("layouts/wrapper", $variables);
    }
}
