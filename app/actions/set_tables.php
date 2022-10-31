<?php

namespace App;

use App\Classes\Database\Column;
use App\Classes\Database\ColumnTemplate;
use App\Classes\Database\CreateTablesQuery;
use App\Classes\Database\Database;
use App\Classes\Database\Driver;
use App\Classes\Database\Table;

use const App\ROOT\SYSTEM_MODE;

$db = new Driver(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$database = new Database(DB_NAME);

$app->db = $db;
$app->tables = $database;

$primaryKeySql = ['not_null' => true, 'primary_key' => true];

$database->set_column_templates(
    new ColumnTemplate('ID', 'id', $primaryKeySql),
    new ColumnTemplate('name', 'name'),
    new ColumnTemplate('status', 'status', ['not_null' => true]),
    new ColumnTemplate('date_add', 'unix', ['not_null' => true])
);

$database->set_tables(
    
    new Table('option', array(
        new Column('$_ID', true),
        new Column('option_key', 'string', ['unique' => true, 'not_null' => true]),
        new Column('option_value', 'big_string')
    )),
 
    new Table('currency', [
        new Column('$_ID'),
        new Column('currency_name', 'name', ['unique' => true, 'not_null' => true]),
        new Column('currency_code', 'currency_code', ['unique' => true, 'not_null' => true]),
        new Column('currency_symbol', '1char', ['not_null' => true]),
        new Column('symbol_position', 'symbol_position'),
        new Column('$_status')
    ]),

    new Table('language', [
        new Column('$_ID'),
        new Column('language_name', 'name', ['unique' => true, 'not_null' => true]),
        new Column('language_code', 'country_code', ['unique' => true, 'not_null' => true]),
        new Column('$_status')
    ]),

    new Table('settings', array(
        new Column('$_ID', true),
        new Column('&_language.language_id'),
        new Column('&_currency.currency_id'),
        new Column('header_scripts', 'text'),
        new Column('footer_scripts', 'text')
    )),

    new Table('phrase', [
        new Column('$_ID'),
        new Column('lang_key', 'name', ['not_null' => true]),
        new Column('phrase_text', 'desc2', ['not_null' => true]),
        new Column('&_language.language_id')
    ]),

    new Table('faq', [
        new Column('$_ID'),
        new Column('faq_title', 'title', ['not_null' => true]),
        new Column('faq_text', 'text', ['not_null' => true]),
        new Column('sort_number', 'int'),
        new Column('title_lang_key', 'name'),
        new Column('text_lang_key', 'name')
    ]),

    new Table('service_category', [
        new Column('$_ID'),
        new Column('service_category_name', 'name', ['not_null' => true]),
        new Column('service_category_slug', 'slug', ['unique' => true, 'not_null' => true]),
        new Column('service_category_image', 'image'),
        new Column('sort_number', 'int'),
        new Column('$_status'),
        new Column('lang_key', 'name')
    ]),

    new Table('service_subcategory', [
        new Column('$_ID'),
        new Column('service_subcategory_name', 'name', ['not_null' => true]),
        new Column('service_subcategory_slug', 'slug', ['unique' => true, 'not_null' => true]),
        new Column('$_status'),
        new Column('lang_key', 'name'),
        new Column('&_service_category.service_category_id')
    ]),

    new Table('service', [
        new Column('$_ID'),
        new Column('service_name', 'name', ['not_null' => true]),
        new Column('service_slug', 'slug', ['unique' => true, 'not_null' => true]),
        new Column('$_status'),
        new Column('lang_key', 'name'),
        new Column('&_service_subcategory.service_subcategory_id')
    ]),

    new Table('user', [
        new Column('$_ID'),
        new Column('first_name', 'name'),
        new Column('last_name', 'name'),
        new Column('user_email', 'email', ['unique' => true, 'not_null' => true]),
        new Column('user_phone', 'full_phone', ['unique' => true]),
        new Column('user_pass', 'pass', ['not_null' => true]),
        new Column('user_status', 'status', ['default' => 'active']),
        new Column('user_role', 'user_role'),
        new Column('user_gender', 'gender'),
        new Column('user_birthday', 'unix'),
        new Column('user_avatar', 'image'),
        new Column('user_balance', 'money', ['default' => 0.00]),
        new Column('user_rating', 'rating'),
        new Column('salon_name', 'name'),
        new Column('mon_worktime', 'time_range'),
        new Column('tue_worktime', 'time_range'),
        new Column('wed_worktime', 'time_range'),
        new Column('thu_worktime', 'time_range'),
        new Column('fri_worktime', 'time_range'),
        new Column('sat_worktime', 'time_range'),
        new Column('sun_worktime', 'time_range'),
        new Column('contact_adress', 'adress'),
        new Column('contact_adress_desc', 'text'),
        new Column('contact_phone', 'full_phone'),
        new Column('contact_phone_2', 'full_phone'),
        new Column('contact_phone_3', 'full_phone'),
        new Column('contact_phone_4', 'full_phone'),
        new Column('facebook_link', 'url'),
        new Column('youtube_link', 'url'),
        new Column('linkedin_link', 'url'),
        new Column('instagram_link', 'url'),
        new Column('pinterest_link', 'url'),
        new Column('salon_id', 'id'),
        new Column('recommended', 'bool'),
        new Column('&_language.language_id', true, ['default' => 1]),
        new Column('confirm_login', 'bool', ['default' => 0]),
        new Column('$_date_add'),
    ]),

    // new Table('master_time', array(
    //     new Column('$_ID', true),
    //     new Column('salon_master_avatar', 'image'),
    //     new Column('salon_master_name', 'name', ['not_null' => true]),
    //     new Column('$_status', true, ['default' => 'active']),
    //     new Column('&_user.user_id'),
    //     new Column('$_date_add'),
    // )),

    new Table('user_photo', array(
        new Column('$_ID', true),
        new Column('photo_path', 'image', ['not_null' => true]),
        new Column('$_status', true, ['default' => 'active']),
        new Column('&_user.user_id'),
        new Column('$_date_add'),
    )),

    new Table('user_service', array(
        new Column('$_ID', true),
        new Column('user_service_name', 'name', ['not_null' => true]),
        new Column('user_service_desc', 'text'),
        new Column('&_service.service_id'),
        new Column('&_user.user_id'),
        new Column('user_service_rating', 'rating'),
        new Column('user_service_price', 'money', ['not_null' => true, 'default' => 0.00]),
        new Column('service_prepay', 'bool', ['default' => 0]),
        new Column('service_prepay_percent', 'ceil_percent'),
        new Column('user_service_time', 'int', ['not_null' => true, 'default' => 0]),
        new Column('time_unit', 'time_unit', ['default' => 'hour']),
        new Column('user_service_discount', 'ceil_percent'),
        new Column('user_service_discount_expire', 'unix'),
        new Column('$_status', true, ['default' => 'active']),
        new Column('$_date_add'),
    )),

    new Table('user_additional_service', array(
        new Column('$_ID', true),
        new Column('user_service_name', 'name', ['not_null' => true]),
        new Column('user_service_desc', 'text'),
        new Column('&_user_service.user_service_id'),
        new Column('user_service_price', 'money', ['not_null' => true, 'default' => 0.00]),
        new Column('user_service_time', 'int', ['not_null' => true, 'default' => 0]),
        new Column('time_unit', 'time_unit', ['default' => 'hour']),
        new Column('$_status', true, ['default' => 'active']),
        new Column('$_date_add'),
    )),

    new Table('user_favorite', array(
        new Column('$_ID', true),
        new Column('user_favorite_type', 'favorite_type'),
        new Column('object_id', 'int', ['not_null' => true]),
        new Column('&_user.user_id'),
        new Column('$_date_add'),
    )),

    new Table('user_service_photo', array(
        new Column('$_ID', true),
        new Column('photo_path', 'image', ['not_null' => true]),
        new Column('$_status', true, ['default' => 'active']),
        new Column('&_user_service.user_service_id'),
        new Column('$_date_add'),
    )),

    new Table('review', array(
        new Column('$_ID', true),
        new Column('review_text', 'text', ['not_null' => true]),
        new Column('review_rating', 'rating'),
        new Column('review_object', 'favorite_type'),
        new Column('review_object_id', 'int'),
        new Column('&_user.user_id'),
        new Column('$_status', true, ['default' => 'active']),
        new Column('$_date_add'),
    )),

    new Table('review_photo', array(
        new Column('$_ID', true),
        new Column('photo_path', 'image', ['not_null' => true]),
        new Column('$_status', true, ['default' => 'active']),
        new Column('&_review.review_id'),
        new Column('$_date_add'),
    )),

    new Table('user_auth', array(
        new Column('$_ID', true),
        new Column('user_auth_token', 'md5', ['not_null' => true]),
        new Column('$_status', 'auth_status'),
        new Column('confirm_code', 'code'),
        new Column('user_auth_expire_date', 'unix', ['not_null' => true]),
        new Column('last_action_time', 'unix'),
        new Column('&_user.user_id'),
        new Column('$_date_add'),
    )),
 
    new Table('payment_method', array(
        new Column('$_ID', true),
        new Column('$_name'),
        new Column('payment_method_comission', 'percent'),
        new Column('payment_method_slug', 'slug', ['not_null' => true, 'unique' => true]),
        new Column('api_settings', 'big_string'),
        new Column('$_status', 'payment_method_status'),
        new Column('min_topup_amount', 'money'),
        new Column('max_topup_amount', 'money'),
        new Column('$_date_add'),
    )),

    new Table('topup', [
        new Column('$_ID'),
        new Column('topup_amount', 'money'),
        new Column('topup_comission_amount', 'money'),
        new Column('topup_comission_percent', 'percent'),
        new Column('topup_status', 'order_status'),
        new Column('&_payment_method.payment_method_id'),
        new Column('&_user.user_id'),
        new Column('$_date_add', 'unix'),
    ]),
    
    new Table('order', [
        new Column('$_ID'),
        new Column('order_name', 'name'),
        new Column('order_amount', 'money'),
        new Column('order_status', 'order_status'),
        new Column('&_user_service.user_service_id'),
        new Column('&_user.user_id'),
        new Column('$_date_add')
    ]),
       


    new Table('chat', array(
        new Column('$_ID', true),
        new Column('$_status', 'chat_status'),
        new Column('$_date_add'),
    )),

    new Table('chat_user', array(
        new Column('$_ID', true),
        new Column('&_chat.chat_id'),
        new Column('&_user.user_id'),
        new Column('$_date_add'),
    )),

    new Table('chat_message', array(
        new Column('$_ID', true),
        new Column('&_chat.chat_id'),
        new Column('&_user.user_id'),
        new Column('chat_message_text', 'text'),
        new Column('message_viewed', 'bool'),
        new Column('$_date_add'),
    ))

);

if(SYSTEM_MODE === 'development' and isset($_GET['db_view']) and $_GET['db_view'] === DB_SETUP_KEY) {
    $CreateTablesQuery = new CreateTablesQuery($database);
    $db->do($CreateTablesQuery->query, true);
    dd($CreateTablesQuery);
}

if(SYSTEM_MODE === 'development' and isset($_GET['db_create']) and $_GET['db_create'] === DB_SETUP_KEY) {
    $db->do('', true, true);
    exit;
}

if(SYSTEM_MODE === 'development' and isset($_GET['db']) and $_GET['db'] === DB_SETUP_KEY) {
    $CreateTablesQuery = new CreateTablesQuery($database);
    $db->do($CreateTablesQuery->query, true);
    dump($CreateTablesQuery);
    exit;
}

if(SYSTEM_MODE === 'development' and $_GET['alter_user'] === DB_SETUP_KEY) {
    $db->do("ALTER TABLE `user` ADD COLUMN user_gender VARCHAR(255) AFTER user_role");
    $db->do("ALTER TABLE `user` ADD COLUMN user_birthday BIGINT(11) AFTER user_gender");
    exit('ok');
}

if(SYSTEM_MODE === 'development' and isset($_GET['option']) and $_GET['option'] === DB_SETUP_KEY) {
    option('frontpage_title', 'frontpage_title_key');
    option('meta_description', 'Описание сайта');
    option('meta_keywords', '');
    option('default_language', 'EN');
    option('site_currency', 'EUR');
    option('facebook_icon', 'EUR');
    option('youtube_icon', 'EUR');
    option('linkedin_icon', 'EUR');
    option('instagram_icon', 'EUR');
    option('pinterest_icon', 'EUR');
    option('review_max_photo_count', '15');
    option('contact_phone', '+79992223232');
    option('requisites', 'ООО iStyle. Адрес г.Москва, ул. Кораблестроителей, дом 32, офис 23');
    // option('default_support_user', 1);
    // option('confirm_login', 1);
    // option('yoomoney_login', '840701');
    // option('yoomoney_pass', 'test_4BA9B3Fq0ymmJcdClTrTLjt5DcIzZ2Yilu5MoIB9Xz0');
    exit('success');
}

if(SYSTEM_MODE === 'development' and isset($_GET['data']) and $_GET['data'] === DB_SETUP_KEY) {
    
    $db->insert('user', [
        'first_name' => 'Admin',
        'user_email' => ADMIN_EMAIL,
        'user_pass' => md5(ADMIN_PASS),
        'user_role' => 'admin',
        'user_status' => 'active',
        'language_id' => 1,
        'user_date_add' => time()
    ]);
    $db->insert('payment_method', [
        'payment_method_comission' => 5.0,
        'payment_method_name' => 'Stripe',
        'payment_method_slug' => 'stripe',
        'payment_method_status' => 'test',
        'min_topup_amount' => 100,
        'max_topup_amount' => 1000000,
        'payment_method_date_add' => time()
    ]);

    exit('success');
}
