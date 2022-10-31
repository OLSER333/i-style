<?php

namespace App;

$allCurrency = $app->db->find('currency', ['currency_status' => 'active'], '*');

if(empty($allCurrency)) {
    $allCurrency[] = [
        'currency_name' => 'Dollar',
        'currency_code' => 'USD',
        'currency_symbol' => '$',
        'symbol_position' => 'left'
    ];
}

$currentCurrency = $app->options['site_currency'];
foreach($allCurrency as $curr) {
    if($curr['currency_code'] === $currentCurrency) {
        $app->currency = $curr;
        break;
    }
}

if(!isset($app->currency)) {
    $app->currency = $allCurrency[0];
}