<?php

namespace App;

$app->url('/', 'App\Controllers\Frontpage->main');

$app->url('/sign_in', 'App\Controllers\Auth->login');
$app->url('/sign_up', 'App\Controllers\Auth->sign_up');
$app->url('/business', 'App\Controllers\Auth->business');
$app->url('/reset', 'App\Controllers\Auth->reset');
// $app->url('/auth/confirm', 'App\Controllers\Auth->auth_confirm');

$app->url('/dashboard', 'App\Controllers\UserProfile->dashboard');
$app->url('/profile/settings', 'App\Controllers\UserProfile->settings');
$app->url('/profile/favorites', 'App\Controllers\UserProfile->favorites');
$app->url('/profile/reviews', 'App\Controllers\UserProfile->reviews');

$app->url('/faq', 'App\Controllers\Pages->faq');
$app->url('/contacts', 'App\Controllers\Pages->contacts');
$app->url('/about', 'App\Controllers\Pages->about');

$app->url('/catalog', 'App\Controllers\Catalog->main');
$app->url('/catalog/{category_slug}', 'App\Controllers\Catalog->category');
$app->url('/catalog/{category_slug}/{subcategory_slug}', 'App\Controllers\Catalog->subcategory');
$app->url('/catalog/{category_slug}/{subcategory_slug}/{tag_slug}', 'App\Controllers\Catalog->tag');

$app->url('/sellers/{seller_id}', 'App\Controllers\Seller->main');
$app->url('/services/{service_id}', 'App\Controllers\Service->main');

$app->url('/api/favorite', 'App\Controllers\Api->favorite');

// $app->url('/inbox', 'App\Controllers\Inbox->main');
// $app->url('/inbox/{chat_id}', 'App\Controllers\Inbox->main');
$app->url('/profile/logout', 'App\Controllers\Profile->profile_logout');

$app->url('/language/{language_code}', function($code){
    $lang = checkLang($code);
    if($lang === false) {
        return false;
    }
    if(is_logged_in()) {
        app()->db->update('user', ['language_id' => $lang['id']], app()->user->user_id);
    } else {
        setUserCookie('user_lang', $lang['code']);
    }
    if(isset($_SERVER['HTTP_REFERER'])) {
        $link = $_SERVER['HTTP_REFERER'];
    } else {
        $link = '/';
    }
    redirect($link);
});

$app->action('set_admin_routes');
