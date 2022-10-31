<?php

use App\Classes\Database\Value;
use App\Classes\Database\ValueConverter;
use App\Classes\Database\Values;

use const App\DATETIME_FORMAT;

$values = new Values(
    new Value('default', array(
        'type' => 'string',
        'max_length' => 255,
    )),
    new Value('id',  array(
        'type' => 'int',
        'max_length' => 9
    )),
    new Value('bigint',  array(
        'type' => 'int',
        'max_length' => 20
    )),
    new Value('phone_code', array(
        'type' => 'int',
        'min_length' => 1,
        'max_length' => 5,
    )),
    new Value('negative_int',  array(
        'type' => 'int',
        'max_length' => 20,
        'negative' => true
    )),
    new Value('int',  array(
        'type' => 'int',
        'max_length' => 9,
        'mask' => 'integer'
    )),
    new Value('code',  array(
        'type' => 'int',
        'length' => 12
    )),
    
    new Value('country_code',  array(
        'type' => 'string',
        'length' => 2
    )),
      
    new Value('currency_code',  array(
        'type' => 'string',
        'length' => 3
    )),
   
    new Value('1char',  array(
        'type' => 'string',
        'length' => 1
    )),

    new Value('symbol_position',  array(
        'type' => 'string',
        'max_length' => 24,
        'select' => ['left', 'right']
    )),
    
    new Value('bool',  array(
        'type' => 'bool'
    )),
    new Value('name', array(
        'type' => 'string',
        'max_length' => 64,
        'filter' => 'string'
    )),
    new Value('phone', array(
        'type' => 'int',
        'min_length' => 5,
        'max_length' => 24,
    )),
    new Value('full_phone', array(
        'type' => 'int',
        'min_length' => 5,
        'max_length' => 24,
        'mask' => 'phone'
    )),
    new Value('title', array(
        'type' => 'string',
        'min_length' => 1,
        'max_length' => 255,
        'filter' => 'string'
    )),
    new Value('slug', array(
        'type' => 'string',
        'min_length' => 1,
        'max_length' => 255,
        'filter' => 'slug'
    )),
    new Value('status', array(
        'type' => 'string',
        'max_length' => 24,
        'select' => ['active', 'inactive', 'deleted']
    )),
    
    new Value('gender', array(
        'type' => 'string',
        'max_length' => 24,
        'select' => ['male', 'female']
    )),
    new Value('string', array(
        'type' => 'string',
        'max_length' => 255,
    )),
    new Value('big_string', array(
        'type' => 'string',
        'max_length' => 1024,
    )),
    new Value('desc', array(
        'type' => 'string',
        'min_length' => 0,
        'max_length' => 2048,
        'textarea' => true,
        'filter' => 'text'
    )),
    new Value('text', array(
        'type' => 'string',
        'min_length' => 0,
        'max_length' => 65000,
        'textarea' => true,
        'filter' => 'text'
    )),
    
    new Value('desc2', array(
        'type' => 'string',
        'min_length' => 0,
        'max_length' => 2048,
        'textarea' => true
    )),
    new Value('email', array(
        'type' => 'string',
        'max_length' => 255,
        'filter' => 'email'
    )),
    new Value('md5', array(
        'type' => 'string',
        'length' => 64
    )),
    new Value('pass', array(
        'type' => 'string',
        'min_length' => 1,
        'max_length' => 255,
        'app_value' => 'md5',
    )),
    new Value('unix', array(
        'type' => 'int',
        'max_length' => 10,
        'negative' => true,
        'public_value' => 'datetime'
    )),
    new Value('datetime', array(
        'type' => 'string',
        'min_length' => 6,
        'max_length' => 48,
        'app_value' => 'unix'
    )),
    new Value('url', array(
        'type' => 'string',
        'min_length' => 4,
        'max_length' => 2048,
        'filter' => 'url',
    )),
    new Value('path', array(
        'type' => 'string',
        'min_length' => 0,
        'max_length' => 2048,
        'filter' => 'string'
    )),

    // new Value('time', array(
    //     'type' => 'string',
    //     'min_length' => 11,
    //     'max_length' => 13,
    //     // 'filter' => 'hours_time',
    //     // 'time_range_min' => '30',
    //     'input' => 'time'          // file, image, time, adress
    // )),

    new Value('time_range', array(
        'type' => 'string',
        'min_length' => 11,
        'max_length' => 13,
        'mask' => 'time_range',
        'filter' => 'time_range'
        // 'time_range_min' => '30',
        // 'input' => 'time'          // file, image, time, adress
    )),

    new Value('adress', array(
        'type' => 'string',
        'min_length' => 0,
        'max_length' => 2048,
        // 'filter' => 'string',
        'input' => 'adress'          // file, image, time, adress
    )),
    
    new Value('image', array(
        'type' => 'string',
        'min_length' => 0,
        'max_length' => 2048,
        'filter' => 'string',
        'input' => 'file',
        'multi' => false,
        'mime' => 'image/*',
        'image' => true          // file, image, time, adress
    )),
    new Value('percent', array(
        'type' => 'float',
        'min_length' => 3,
        'max_length' => 12,
        'float' => [4, 1]
    )),
    new Value('ceil_percent',  array(
        'type' => 'int',
        'max_length' => 3,
        'max_value' => 100,
        'mask' => 'ceil_percent'
    )),
    new Value('float', array(
        'type' => 'float',
        'float' => [15, 2]
    )),
    new Value('money', array(
        'type' => 'float',
        'min_length' => 4,
        'max_length' => 20,
        'float' => [15, 2],
        'mask' => 'money',
        'filter' => 'money',
        'min_value' => 0.00
    )),
    new Value('rating', array(
        'type' => 'float',
        'length' => 4,
        'float' => [3, 2],
        'mask' => 'rating',
        'min_value' => 0.00,
        'max_value' => 5.00
    )),
    new Value('currency', array(
        'type' => 'string',
        'length' => 3,
        'select' => ['USD', 'RUR']
    )),
    new Value('user_status', array(
        'type' => 'string',
        'max_length' => 24,
        'select' => ['active', 'inactive', 'deleted']
    )),
    new Value('time_unit', array(
        'type' => 'string',
        'max_length' => 24,
        'select' => ['hour', 'minute']
    )),
    new Value('favorite_type', array(
        'type' => 'string',
        'max_length' => 24,
        'select' => ['seller', 'service']
    )),
    new Value('payment_method_status', array(
        'type' => 'string',
        'max_length' => 24,
        'select' => ['active', 'inactive', 'test']
    )),
    new Value('auth_status', array(
        'type' => 'string',
        'max_length' => 24,
        'select' => ['active', 'inactive', 'wait_confirm_code', 'bad_login', 'blocked']
    )),
    new Value('user_role', array(
        'type' => 'string',
        'max_length' => 24,
        'select' => ['customer', 'master', 'salon', 'salon_master', 'admin']
    )),
    new Value('content', array(
        'type' => 'string',
        'max_length' => 20000,
        'textarea' => true,
        'editor' => true
    )),
    new Value('salt', array(
        'type' => 'string',
        'length' => 12
    )),
    new Value('user_confirmation', array(
        'type' => 'string',
        'max_length' => 24,
        'select' => ['confirmed', 'declined', 'new']
    )),
    new Value('order_status', array(
        'type' => 'string',
        'max_length' => 24,
        'select' => ['new', 'done', 'canceled', 'process']
    )),
    
    new Value('chat_status', array(
        'type' => 'string',
        'max_length' => 24,
        'select' => ['open', 'closed', 'deleted']
    ))
);

$ValueConverter = new ValueConverter();
$ValueConverter->new_method('unix_to_datetime', function($unix){
    $unix = intval($unix);
    if($unix === 0)
        return 'Нет данных';
    $date = new DateTime();
    $date->setTimestamp($unix);
    return $date->format(DATETIME_FORMAT);
});
$ValueConverter->new_method('datetime_to_unix', function($datetime){
    $date = new DateTime($datetime);
    return $date->getTimestamp();
});
$ValueConverter->new_method('pass_to_md5', function($pass){
    return md5($pass);
});

$app->values = $values;
$app->values->converter = $ValueConverter;
