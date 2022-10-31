<?php

namespace App;

use App\Classes\User;

$app->user = new User;

$languages = $app->db->find('language', ['language_status' => 'active'], '*');


if(empty($languages)) {
    $languages[] = [
        'language_id' => 1,
        'languange_code' => 'EN',
        'languange_name' => 'English'
    ];
}


foreach($languages as $lang) {
    $app->languages[intval($lang['language_id'])] = $lang;
}



if(!isset($app->user->language_id)) {
    $app->user->language_id = 1;
    if(!is_logged_in() and isset($_COOKIE['user_lang'])) {
        $newlang = checkLang($_COOKIE['user_lang']);
        if($newlang !== false) {
            $app->user->language_id = intval($newlang['id']);
        } else {
            $app->user->language_id = 1;
        }
    }
}

foreach($app->languages as $langId => $ulang) {
    if($langId === intval($app->user->language_id)) {
        $languages = $app->languages;
        unset($app->languages);
        $app->languages = [$langId => $ulang] + $languages;
        break;
    }
}

$app->user_lang_code = $app->languages[$app->user->language_id]['language_code'];
