<?php

$app->data['text'] = [
    'user' => 'Пользователь',
    'users' => 'Пользователи',
    'user_id' => 'uid',
    'first_name' => 'Имя',
    'last_name' => 'Фамилия',
    'user_email' => 'Почта',
    'user_status' => 'Статус',
    'user_role' => 'Роль',
    'user_pass' => 'Пароль',
    'user_balance' => 'Баланс',
    'user_date_add' => 'Добавлен',
    'subscription_expire' => 'Подписка',
    'confirm_login' => 'Подтверждение входа по email',

    'link' => 'Ссылка',
    'links' => 'Ссылки',
    
    'click' => 'Клик',
    'clicks' => 'Клики',
   
    'order' => 'Заказ',
    'orders' => 'Заказы',
    'order_id' => 'ID',
    'order_name' => 'Название',
    'order_amount' => 'Сумма',
    'order_status' => 'Статус',
    'order_date_add' => 'Добавлено',

    'topup' => 'Пополнение',
    'topups' => 'Пополнения',
    'topup_id' => 'ID',
    'topup_amount' => 'Сумма',
    'topup_comission_amount' => 'Комиссия',
    'topup_status' => 'Статус',
    'topup_date_add' => 'Добавлено',

    'payment_method_id' => 'Платёжная система',
    'payment_method' => 'Платёжная система',
    'payment_methods' => 'Платёжные системы',
    'payment_method_name' => 'Название',
    'payment_method_slug' => 'Адрес',
    'payment_method_status' => 'Статус',
    'payment_method_comission' => 'Комиссия',
    'payment_method_date_add' => 'Добавлено',
    'min_topup_amount' => 'Мин. сумма',
    'max_topup_amount' => 'Макс. сумма',

    'saved' => 'Данные сохранены',
    'invalid_data' => 'Неправильные данные',

    'save' => 'Сохранить',
    'cancel' => 'Отменить',

    'confirm_delete' => 'Подтвердите удаление',
    'confirm_full_delete' => 'Подтвердите полное удаление. Это действие нельзя отменить.',

    'name' => 'Название', 
    'created' => 'Создано',

    'done' => 'Выполнен',
    'process' => 'В процессе',
    'cancel' => 'Отменён',

    'month_subscription_price' => 'Цена за подписку (месяц)',
    'week_subscription_price' => 'Цена за подписку (неделя)',
    'default_support_user' => 'ID пользователя тех.поддержки по-умолчанию',
    'frontpage_title' => 'Заголовок главной страницы',
 
    'get_chat' => 'Выберите чат',
    'no_chats' => 'Чатов пока нет',

    'no_msg' => 'Нет сообщений',
    'type_here' => 'Напишите сообщение...'

];

$langId = $app->user->language_id;
$phrases = $app->db->find('phrase', ['language_id' => $langId]);

foreach($phrases as $phrase) {
    $app->data['text'][$phrase['lang_key']] = $phrase['phrase_text'];
}
