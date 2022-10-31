<?php

namespace App\ROOT;

const SYSTEM_NAME   = 'App',
      SYSTEM_MODE   = 'development',    // development, testing, production
      ABSPATH       = __DIR__,
      RELPATH       = '',
      SAVE_CACHE    = false;

const MAX_EXECUTION_TIME  = 300,
      MEMORY_LIMIT        = '128M',
      DISPLAY_ERRORS      = true;

ini_set('max_execution_time', MAX_EXECUTION_TIME);
ini_set('memory_limit', MEMORY_LIMIT);
ini_set('display_errors', DISPLAY_ERRORS);
ini_set('fbsql.generate_warnings', DISPLAY_ERRORS);
ini_set('assert.warning', DISPLAY_ERRORS);
ini_set('html_errors', DISPLAY_ERRORS);
ini_set('display_startup_errors', DISPLAY_ERRORS);
ini_set("error_reporting", \E_ALL);

include_once __DIR__.'/app/config.php';
