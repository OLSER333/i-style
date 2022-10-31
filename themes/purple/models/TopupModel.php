<?php

namespace Themes\Purple\Models;

use App\System\Core\Model;

class TopupModel extends PurpleModel
{
    function __construct(Model $topupContent, string $openButtonClass, string $activeClass = 'active', array $variables = [])
    {
        $variables['content'] = $topupContent;
        $variables['open_button'] = $openButtonClass;
        $variables['active_class'] = $activeClass;
        $variables['topup_id'] = md5(rand(100000, 999999).'-'.microtime());
        parent::__construct('layouts/topup', $variables);
    }
}
