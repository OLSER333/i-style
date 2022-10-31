<?php

namespace Themes\Purple\Models;

use App\System\Core\Model;

use const App\SITE_NAME;

use function App\app;

class LayoutModel extends PurpleModel
{
    function __construct(string $title, Model $content, array $variables = [])
    {
        $variables['keywords'] = app()->options['meta_keywords'];
        $variables['description'] = app()->options['meta_description'];
        $variables['lang'] = strtolower(app()->user_lang_code);
        $variables['title'] = $title.' - '.SITE_NAME;
        $variables['content'] = $content;
        parent::__construct('layout', $variables);
    }
}
