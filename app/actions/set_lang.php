<?php

namespace App;

$user_lang = $app->user->language_id;

$languages = $app->db->find('language', ['language_status' => 'active'], '*', "CASE WHEN `language_id` = $user_lang THEN `language_id` != $user_lang ELSE `language_code` END ");

foreach($languages as $lang) {
    $app->languages[$lang['language_id']] = $lang;
}

$app->user_lang_code = $app->languages[$app->user->language_id]['language_code'];