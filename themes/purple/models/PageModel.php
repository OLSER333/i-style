<?php

namespace Themes\Purple\Models;

use App\System\Core\Model;

use function App\get_text;
use function App\getRefer;

class PageModel extends ContentModel
{
    function __construct(string $title, Model $content, string|null $page_title = null, array|null $breadcrumbs = null, string $wrapper_class = '', string $body_class = '', string $back_url = '', array $title_breadcrumbs = [], array $variables = [], bool $display_title = true, Model|false $additional_content = false)
    {
        if($page_title === null) {
            $page_title = get_text($title);
        }
        if($breadcrumbs === null or empty($breadcrumbs)) {
            $breadcrumbs = [
                [
                    'title' => get_text('home'),
                    'link' => '/',
                    'active' => false
                ],
                [
                    'title' => $title,
                    'link' => '',
                    'active' => true
                ]
            ];
        }
        if($back_url === '') {
            $back_url = '/';
        }
        $variables['back_button_url'] = $back_url;
        $variables['title_breadcrumbs'] = $title_breadcrumbs;
        $variables['content'] = $content;
        $variables['page_title'] = $page_title;
        $variables['breadcrumbs'] = $breadcrumbs;
        $variables['wrapper_class'] = $wrapper_class;
        $variables['display_title'] = $display_title;
        $variables['additional_content'] = $additional_content;
        parent::__construct($title, new PurpleModel('layouts/page', $variables), [], $body_class);
    }
}
