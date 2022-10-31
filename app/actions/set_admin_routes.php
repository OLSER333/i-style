<?php

namespace App;

use App\Classes\Admin\AdminRoute;

if(!is_admin())
    return;

$app->url('/admin/dashboard', function(){
    redirect('/admin');
});

$app->url('/admin', 'App\Controllers\Admin->dashboard');
$app->url('/admin/settings', 'App\Controllers\Admin->settings');
$app->url('/admin/profile/settings', 'App\Controllers\Admin->profile');

new AdminRoute('user', array(
    'default' => [
        'user_id',
        'first_name',
        'last_name',
        'user_email',
        'user_phone',
        'user_status',
        'user_role',
        'language_id',
        'user_date_add'
    ],
    'table' => true,
    'edit' => [
        'first_name',
        'last_name',
        'user_email',
        'user_phone',
        'user_pass',
        'user_status',
        'user_role',
        'language_id',
        'confirm_login'
    ],
    'create' => [
        'first_name',
        'last_name',
        'user_email',
        'user_phone',
        'user_pass',
        'user_status',
        'user_role',
        'language_id',
        'confirm_login'
    ],
    'view' => true,
    'delete' => true,
    'trash' => true
), 'user_id', 'user_status', 'first_name', function($data){
    return addLangToData($data);
}, 'users');


new AdminRoute('user', array(
    'default' => [
        'user_id',
        'first_name',
        'last_name',
        'user_email',
        'user_phone',
        'user_status',
        'user_balance',
        'language_id',
        'user_date_add'
    ],
    'table' => true,
    'edit' => [
        'first_name',
        'last_name',
        'user_email',
        'user_phone',
        'user_pass',
        'user_status',
        'user_balance',
        'language_id',
        'confirm_login',
        'user_avatar'
    ],  
    'create' => [
        'first_name',
        'last_name',
        'user_email',
        'user_phone',
        'user_pass',
        'user_status',
        'user_balance',
        'language_id',
        'confirm_login',
        'user_avatar'
    ],
    'view' => true,
    'delete' => true,
    'trash' => true
), 'user_id', 'user_status', 'first_name', function($data){
    return addLangToData($data);
}, 'customers', ["user.user_role = 'customer'"], ['user_role' => 'customer']);


new AdminRoute('user', array(
    'default' => [
        'user_id',
        'first_name',
        'last_name',
        'user_email',
        'user_phone',
        'user_status',
        'user_balance',
        'user_rating',
        'language_id',
        'user_date_add'
    ],
    'table' => true,
    'edit' => [
        'recommended',
        'first_name',
        'last_name',
        'user_email',
        'user_phone',
        'user_pass',
        'user_status',
        'user_balance',
        'user_rating',
        'mon_worktime',
        'tue_worktime',
        'wed_worktime',
        'thu_worktime',
        'fri_worktime',
        'sat_worktime',
        'sun_worktime',
        'contact_adress',
        'contact_adress_desc',
        'contact_phone',
        'contact_phone_2',
        'contact_phone_3',
        'contact_phone_4',
        'facebook_link',
        'youtube_link',
        'linkedin_link',
        'instagram_link',
        'pinterest_link',
        'language_id',
        'confirm_login',
        'user_avatar'
    ],
    'create' => [
        'recommended',
        'first_name',
        'last_name',
        'user_email',
        'user_phone',
        'user_pass',
        'user_status',
        'user_balance',
        'user_rating',
        'mon_worktime',
        'tue_worktime',
        'wed_worktime',
        'thu_worktime',
        'fri_worktime',
        'sat_worktime',
        'sun_worktime',
        'contact_adress',
        'contact_adress_desc',
        'contact_phone',
        'contact_phone_2',
        'contact_phone_3',
        'contact_phone_4',
        'facebook_link',
        'youtube_link',
        'linkedin_link',
        'instagram_link',
        'pinterest_link',
        'language_id',
        'confirm_login',
        'user_avatar'
    ],
    'view' => true,
    'delete' => true,
    'trash' => true
), 'user_id', 'user_status', 'first_name', 
function($data){
    return addLangToData($data);
}, 'masters', ["user.user_role = 'master'"], ['user_role' => 'master']);

new AdminRoute('user', array(
    'default' => [
        'user_id',
        'first_name',
        'last_name',
        'user_email',
        'user_phone',
        'user_status',
        'user_balance',
        'user_rating',
        'language_id',
        'user_date_add'
    ],
    'table' => true,
    'edit' => [
        'first_name',
        'last_name',
        'user_email',
        'user_phone',
        'user_pass',
        'user_status',
        'user_balance',
        'user_rating',
        'mon_worktime',
        'tue_worktime',
        'wed_worktime',
        'thu_worktime',
        'fri_worktime',
        'sat_worktime',
        'sun_worktime',
        'language_id',
        'confirm_login',
        'user_avatar'
    ],
    'create' => [
        'first_name',
        'last_name',
        'user_email',
        'user_phone',
        'user_pass',
        'user_status',
        'user_balance',
        'user_rating',
        'mon_worktime',
        'tue_worktime',
        'wed_worktime',
        'thu_worktime',
        'fri_worktime',
        'sat_worktime',
        'sun_worktime',
        'language_id',
        'salon_id',
        'confirm_login',
        'user_avatar'
    ],
    'view' => true,
    'delete' => true,
    'trash' => true
), 'user_id', 'user_status', 'first_name', 
function($data){
    return addLangToData($data);
}, 'salon_masters', ["user.user_role = 'salon_master'"], ['user_role' => 'salon_master']);


new AdminRoute(
    'user',
    array(
        'default' => [
            'user_id',
            'first_name',
            'last_name',
            'salon_name',
            'user_email',
            'user_phone',
            'user_status',
            'user_balance',
            'user_rating',
            'language_id',
            'user_date_add'
        ],
        'table' => true,
        'edit' => [
            'recommended',
            'first_name',
            'last_name',
            'salon_name',
            'user_email',
            'user_phone',
            'user_pass',
            'user_status',
            'user_balance',
            'user_rating',
            'mon_worktime',
            'tue_worktime',
            'wed_worktime',
            'thu_worktime',
            'fri_worktime',
            'sat_worktime',
            'sun_worktime',
            'contact_adress',
            'contact_adress_desc',
            'contact_phone',
            'contact_phone_2',
            'contact_phone_3',
            'contact_phone_4',
            'facebook_link',
            'youtube_link',
            'linkedin_link',
            'instagram_link',
            'pinterest_link',
            'language_id',
            'confirm_login',
            'user_avatar'
        ],
        'create' => [
            'recommended',
            'first_name',
            'last_name',
            'salon_name',
            'user_email',
            'user_phone',
            'user_pass',
            'user_status',
            'user_balance',
            'user_rating',
            'mon_worktime',
            'tue_worktime',
            'wed_worktime',
            'thu_worktime',
            'fri_worktime',
            'sat_worktime',
            'sun_worktime',
            'contact_adress',
            'contact_adress_desc',
            'contact_phone',
            'contact_phone_2',
            'contact_phone_3',
            'contact_phone_4',
            'facebook_link',
            'youtube_link',
            'linkedin_link',
            'instagram_link',
            'pinterest_link',
            'language_id',
            'confirm_login',
            'user_avatar'
        ],
        'view' => true,
        'delete' => true,
        'trash' => true
    ),
    'user_id',
    'user_status',
    'salon_name',
    function($data){
        return addLangToData($data);
    },
    'salons',
    ["user.user_role = 'salon'"],
    ['user_role' => 'salon']
);


new AdminRoute('user_photo', array(
    'default' => [
        'user_photo_id',
        'photo_path',
        'user_id',
        'user_photo_status',
        'user_photo_date_add'
    ],
    'table' => true,
    'create' => [
        'photo_path',
        'user_id',
        'user_photo_status'
    ],
    'view' => true,
    'edit' => [
        'photo_path',
        'user_id',
        'user_photo_status'
    ],
    'delete' => true,
    'trash' => true
), 'user_photo_id');


new AdminRoute('user_service', array(
    'default' => [
        'user_service_id',
        'user_service_name',
        'user_service_price',
        'user_service_time',
        'time_unit',
        'service_id',
        'user_id',
        'user_service_rating',
        'user_service_status',
        'user_service_date_add'
    ],
    'table' => true,
    'create' => [
        'user_service_name',
        'user_service_desc',
        'user_service_price',
        'user_service_time',
        'time_unit',
        'user_service_discount',
        'user_service_discount_expire',
        'service_prepay',
        'service_prepay_percent',
        'service_id',
        'user_id',
        'user_service_rating',
        'user_service_status'
    ],
    'view' => true,
    'edit' => [
        'user_service_name',
        'user_service_desc',
        'user_service_price',
        'user_service_time',
        'time_unit',
        'user_service_discount',
        'user_service_discount_expire',
        'service_prepay',
        'service_prepay_percent',
        'service_id',
        'user_id',
        'user_service_rating',
        'user_service_status'
    ],
    'delete' => true,
    'trash' => true
), 'user_service_id');

new AdminRoute('user_service_photo', array(
    'default' => [
        'user_service_photo_id',
        'photo_path',
        'user_service_id',
        'user_service_photo_status',
        'user_service_photo_date_add'
    ],
    'table' => true,
    'create' => [
        'photo_path',
        'user_service_id',
        'user_service_photo_status'
    ],
    'view' => true,
    'edit' => [
        'photo_path',
        'user_service_id',
        'user_service_photo_status'
    ],
    'delete' => true,
    'trash' => true
), 'user_service_photo_id');


new AdminRoute('user_additional_service', array(
    'default' => [
        'user_additional_service_id',
        'user_service_name',
        'user_service_desc',
        'user_service_price',
        'user_service_time',
        'time_unit',
        'user_service_id',
        'user_additional_service_status',
        'user_additional_service_date_add'
    ],
    'table' => true,
    'create' => [
        'user_service_name',
        'user_service_desc',
        'user_service_price',
        'user_service_time',
        'time_unit',
        'user_service_id',
        'user_additional_service_status'
    ],
    'view' => true,
    'edit' => [
        'user_service_name',
        'user_service_price',
        'user_service_time',
        'time_unit',
        'user_service_id',
        'user_additional_service_status'
    ],
    'delete' => true,
    'trash' => true
), 'user_additional_service_id');



new AdminRoute('review', array(
    'default' => [
        'review_id',
        'review_text',
        'review_rating',
        'user_id',
        'user_service_id',
        'review_status',
        'review_date_add'
    ],
    'table' => true,
    'create' => [
        'review_text',
        'review_rating',
        'user_id',
        'user_service_id',
        'review_status'
    ],
    'view' => true,
    'edit' => [
        'review_text',
        'review_rating',
        'user_id',
        'user_service_id',
        'review_status'
    ],
    'delete' => true,
    'trash' => true
), 'review_id');

new AdminRoute('review_photo', array(
    'default' => [
        'review_photo_id',
        'photo_path',
        'review_id',
        'review_photo_status',
        'review_photo_date_add'
    ],
    'table' => true,
    'create' => [
        'photo_path',
        'review_id',
        'review_photo_status'
    ],
    'view' => true,
    'edit' => [
        'photo_path',
        'review_id',
        'review_photo_status'
    ],
    'delete' => true,
    'trash' => true
), 'review_photo_id');

// new AdminRoute('topup', array(
//     'default' => [
//         'topup_id',
//         'topup_amount',
//         'topup_comission_amount',
//         'topup_status',
//         'payment_method_id',
//         'user_id',
//         'topup_date_add'
//     ],
//     'table' => true,
//     'create' => [
//         'topup_amount',
//         'topup_comission_amount',
//         'topup_status',
//         'payment_method_id',
//         'user_id',
//         'topup_date_add'
//     ],
//     'info' => true,
//     'edit' => [
//         'topup_amount',
//         'topup_comission_amount',
//         'topup_status',
//         'payment_method_id',
//         'user_id',
//         'topup_date_add'
//     ],
//     'delete' => true,
//     'trash' => true
// ), 'topup_id');

new AdminRoute('order', array(
    'default' => [
        'order_id',
        'order_name',
        'order_amount',
        'order_status',
        'user_id',
        'order_date_add'
    ],
    'table' => true,
    'create' => [
        'order_name',
        'order_amount',
        'order_status',
        'user_id',
        'order_date_add'
    ],
    'view' => true,
    'edit' => [
        'order_name',
        'order_amount',
        'order_status',
        'user_id',
        'order_date_add'
    ],
    'delete' => true,
    'trash' => true
), 'order_id');

new AdminRoute('payment_method', array(
    'default' => [
        'payment_method_id',
        'payment_method_name',
        'payment_method_slug',
        'payment_method_status',
        'payment_method_comission',
        'min_topup_amount',
        'max_topup_amount',
        'payment_method_date_add'
    ],
    'table' => true,
    'edit' => [
        'payment_method_name',
        'payment_method_slug',
        'payment_method_status',
        'payment_method_comission',
        'min_topup_amount',
        'max_topup_amount'
    ]
), 'payment_method_id');


new AdminRoute('currency', array(
    'default' => true,
    'table' => true,
    'create' => [
        'currency_name',
        'currency_code',
        'currency_symbol',
        'symbol_position',
        'currency_status'
    ],
    'view' => true,
    'edit' => [
        'currency_name',
        'currency_code',
        'currency_symbol',
        'symbol_position',
        'currency_status'
    ],
    'delete' => true,
    'trash' => true
), 'currency_id');

new AdminRoute('language', array(
    'default' => true,
    'table' => true,
    'create' => [
        'language_name',
        'language_code',
        'language_status'
    ],
    'view' => true,
    'edit' =>  [
        'language_name',
        'language_code',
        'language_status'
    ],
    'delete' => true,
    'trash' => true
), 'language_id');

new AdminRoute('faq', array(
    'default' => [
        'faq_id',
        'faq_title',
        'sort_number',
        'title_lang_key',
        'text_lang_key'
    ],
    'table' => true,
    'create' => [
        'faq_title',
        'faq_text',
        'sort_number',
        'title_lang_key',
        'text_lang_key'
    ],
    'view' => true,
    'edit' => [
        'faq_title',
        'faq_text',
        'sort_number',
        'title_lang_key',
        'text_lang_key'
    ],
    'delete' => true
), 'faq_id');

new AdminRoute('phrase', array(
    'default' => true,
    'table' => true,
    'create' => [
        'lang_key',
        'phrase_text',
        'language_id'
    ],
    'view' => true,
    'edit' => [
        'lang_key',
        'phrase_text',
        'language_id'
    ],
    'delete' => true
), 'phrase_id', '', '', function($data){
    return addLangToData($data, 'language');
});


new AdminRoute('service_category', array(
    'default' => [
        'service_category_id',
        'service_category_name',
        'service_category_slug',
        'sort_number',
        'lang_key',
        'service_category_status'
    ],
    'table' => true,
    'create' => [
        'service_category_name',
        'lang_key',
        'service_category_slug',
        'service_category_image',
        'sort_number',
        'service_category_status'
    ],
    'view' => true,
    'edit' =>  [
        'service_category_name',
        'lang_key',
        'service_category_slug',
        'service_category_image',
        'sort_number',
        'service_category_status'
    ],
    'delete' => true
), 'service_category_id');


new AdminRoute('service_subcategory', array(
    'default' => true,
    'table' => true,
    'create' =>  [
        'service_subcategory_name',
        'lang_key',
        'service_subcategory_slug',
        'service_subcategory_status',
        'service_category_id'
    ],
    'view' => true,
    'edit' => [
        'service_subcategory_name',
        'lang_key',
        'service_subcategory_slug',
        'service_subcategory_status',
        'service_category_id'
    ],
    'delete' => true
), 'service_subcategory_id');


new AdminRoute('service', array(
    'default' => true,
    'table' => true,
    'create' =>  [
        'service_name',
        'lang_key',
        'service_slug',
        'service_status',
        'service_subcategory_id'
    ],
    'view' => true,
    'edit' => [
        'service_name',
        'lang_key',
        'service_slug',
        'service_status',
        'service_subcategory_id'
    ],
    'delete' => true
), 'service_id');
