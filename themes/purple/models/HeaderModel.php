<?php

namespace Themes\Purple\Models;

use function App\app;
use function App\get_text;
use function App\get_user_avatar;
use function App\getUserAvatar;
use function App\is_logged_in;
use function App\user;

class HeaderModel extends PurpleModel
{
    function __construct(array $variables = [])
    {
        $i = 0;
        foreach(app()->categoriesMenu->items as $item) {
            $i++;
            if($i <= 6) {
                $variables['main_menu'][] = $item;
            } else {
                $variables['additional_menu'][] = $item;
            }
        }
        $user_lang = app()->user->language_id;
        $variables['user_role'] = app()->user->user_role;

        foreach(app()->languages as $key => $lang) {
            $variables['lang_menu'][$key]['lang_code'] = $lang['language_code'];
            $variables['lang_menu'][$key]['lang_link'] = '/language/'.strtolower($lang['language_code']);
            if(intval($user_lang) === intval($lang['language_id'])) {
                $variables['current_lang'] = $lang['language_code'];
                $variables['lang_menu'][$key]['active_class'] = 'active-lang-item';
            } else {
                $variables['lang_menu'][$key]['active_class'] = '';
            }
        }
        if(is_logged_in()) {
            $last_name = '';
            if(user()->last_name !== null and user()->last_name !== '') {
                $last_name = ' '.mb_substr(user()->last_name, 0, 1).'.';
            }
            $variables['header_user_name'] = user()->first_name.$last_name;
            $variables['display_auth_menu'] = true;
        }
        $salons_count = count(app()->salons);
        $variables['salons_with_us'] = get_text('salons_with_us', false, $salons_count);
        parent::__construct('blocks/header', $variables);
    }
}
