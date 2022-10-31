<?php

namespace App;

use App\Classes\Menu\Menu;
use App\Classes\Menu\MenuItem;

use const App\ROOT\ABSPATH;

switch ($app->user->user_role) {
    case 'user':
        // $app->menu = new Menu('main_menu',
        //     new MenuItem('Статистика', '/dashboard', 'dashboard'),
        //     new MenuItem('Мои ссылки', '/links', 'stats'),
        //     new MenuItem('Привязать статистику', '/links/create', 'link'),
        //     new MenuItem('Оплата', '/payments', 'wallet'),
        //     new MenuItem('Инструкции', '/#faq', 'faq'),
        //     new MenuItem('Поддержка', '/inbox', 'contact')
        // );
        break;

    case 'admin':
        $app->menu = new Menu(
            'main_menu',
            new MenuItem('Статистика', '/admin/dashboard', 'dashboard'),
            new MenuItem('Все пользователи', '/admin/users', 'user'),
            new MenuItem('Клиенты', '/admin/customers', 'user'),
            new MenuItem('Салоны', '/admin/salons', 'user'),
            new MenuItem('Мастера салонов', '/admin/salon_masters', 'user'),
            new MenuItem('Частные мастера', '/admin/masters', 'user'),
            new MenuItem('Фотографии пользователей', '/admin/user_photo', 'user'),
            new MenuItem('Заказы', '/admin/order', 'card'),
            new MenuItem('Платёжные системы', '/admin/payment_method', 'card'),
            new MenuItem('Категории услуг', '/admin/service_category', 'category'),
            new MenuItem('Подкатегории услуг', '/admin/service_subcategory', 'category'),
            new MenuItem('Услуги', '/admin/service', 'category'),
            new MenuItem('Услуги пользователей', '/admin/user_service', 'category'),
            new MenuItem('Доп.услуги', '/admin/user_additional_service', 'category'),
            new MenuItem('Фотогалереи услуг', '/admin/user_service_photo', 'category'),
            new MenuItem('Отзывы', '/admin/review', 'category'),
            new MenuItem('Фотографии отзывов', '/admin/review_photo', 'category'),
            new MenuItem('Валюты', '/admin/currency', 'currency'),
            new MenuItem('Языки', '/admin/language', 'translate'),
            new MenuItem('Фразы', '/admin/phrase', 'font'),
            new MenuItem('Вопросы и ответы', '/admin/faq', 'question'),
            new MenuItem('Настройки', '/admin/settings', 'settings')
            // new MenuItem('Пополнения', '/admin/topup', 'wallet'),
            // new MenuItem('Сообщения', '/inbox', 'chat'),
        );
        break;


    case 'guest':
        $app->menu = new Menu(
            'main_menu',
            new MenuItem('Вход', '/login', 'login'),
            new MenuItem('Регистрация', '/sign_up', 'user'),
            // new MenuItem('Инструкции', '/faq', 'faq')
        );
        break;
}

$categories = app()->db->find('service_category', ['service_category_status' => 'active'], '*', 'CASE WHEN `sort_number` > 0 THEN `sort_number` = 0 ELSE `service_category_id` END ', false);

foreach ($categories as $key => $category) {
    if (empty($category['service_category_image']) or !file_exists(ABSPATH . $category['service_category_image'])) {
        $categories[$key]['service_category_image'] = '/assets/img/no_image.png';
    }
}

$app->categories = $categories;
$app->categoriesMenu = new Menu('categories_menu');

$app->categoriesMenu->add(new MenuItem(
    get_text('service_catalog', 'Catalog'),
    '/catalog',
    '',
    '',
    'active-item',
    ''
));

foreach ($categories as $menuItem) {
    $app->categoriesMenu->add(new MenuItem(
        get_text($menuItem['lang_key'], $menuItem['service_category_name']),
        '/catalog/' . $menuItem['service_category_slug'],
        '',
        '',
        'active-item',
        ''
    ));
}
