<?php

namespace Themes\Purple\Models;

use App\System\Core\Model;

class ContentModel extends LayoutModel
{
    function __construct(string $title, Model $content, array $variables = [], string $body_class = '')
    {
        $variables['header'] = new HeaderModel();
        $variables['content'] = $content;
        $variables['footer'] = new FooterModel();
        $mainContent = new PurpleModel('layouts/content', $variables);
        parent::__construct($title, $mainContent, ['body_class' => $body_class]);
    }
}
