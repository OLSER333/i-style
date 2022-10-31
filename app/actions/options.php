<?php

namespace App;

$options = db()->find('option');

foreach($options as $option) {
    $app->options[$option['option_key']] = $option['option_value'];
}
