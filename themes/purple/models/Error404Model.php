<?php

namespace Themes\Purple\Models;

use function App\get_text;
use function App\getRefer;

class Error404Model extends ContentModel
{
    function __construct()
    {
        $variables['refer'] = getRefer();
        parent::__construct(get_text('error_404'), new PurpleModel('content/error404', $variables), [], 'default-page-wrapper');
    }
}
