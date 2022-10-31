<?php

namespace Themes\Purple\Models;

use function App\app;

class FooterModel extends PurpleModel
{
    function __construct(array $variables = [])
    {
        $categories = array_slice(app()->categoriesMenu->items, 0, 8);
        $categories = array_chunk($categories, 4);

        $variables['categories'] = $categories;
        $variables['year'] = date('Y', time());
        $variables['body_class'] = 'dfgdgdfgdfg';
        parent::__construct('blocks/footer', $variables);
    }
}
