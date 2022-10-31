<?php

namespace App\System;

include_once __DIR__.'/functions.php';
include_once __DIR__.'/core/Autoload.php';

new Core\Autoload(__DIR__.'/core', __NAMESPACE__.'\Core');

set_error_handler(function($severity, $message, $filename, $lineno) {
    writelog([
        "Severity: $severity",
        "Message: $message",
        "File: $filename",
        "Line: $lineno"
    ], 'Error', true);
});
